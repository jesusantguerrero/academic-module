<?php

namespace Modules\Academic\Entities;

use App\Models\ResourceSchedule;
use App\Domains\CRM\Models\Client;
use Insane\Journal\Models\Invoice\Invoice;
use Insane\Journal\Traits\Transactionable;
use App\Domains\CRM\Models\ContactRelation;
use Insane\Journal\Models\Core\Transaction;
use Insane\Journal\Traits\IPayableDocument;
use Insane\Journal\Traits\HasPaymentDocuments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Academic\Database\factories\AdmissionFactory;

class Admission extends Transactionable implements IPayableDocument {
    use HasPaymentDocuments;
    use HasFactory;

    const ACTION_ENROLL = 'enroll';
    const ACTION_RE_ENROLL = 're_enroll';
    const ACTION_PROMOTE = 'promoted';
    const ACTION_REPEAT = 'repeat';

    const TYPE_ENROLLMENT = 'enrollment';
    const TYPE_RE_ENROLLMENT = 're-enrollment';

    const INVOICE_TYPE_ENROLLMENT = 'enrollment';
    const INVOICE_TYPE_MONTH = 'month';

    const STATUS_DRAFT = 'draft';
    const STATUS_REJECTED = 'rejected';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_RE_ENROLLED = 're-enrolled';

    const PAYMENT_STATUS_ACTIVE = 'active';
    const PAYMENT_STATUS_GRACE = 'grace';
    const PAYMENT_STATUS_LATE = 'late';
    const PAYMENT_STATUS_PARTIALLY_PAID = 'partially_paid';
    const PAYMENT_STATUS_PAID = 'paid';
    const PAYMENT_STATUS_CANCELLED = 'cancelled';
    const PAYMENT_STATUS_EXPIRED = 'expired';

    // protected
    protected $creditCategory = 'expected_payments_customers';
    protected $creditAccount = 'Customer Demand Deposits';
    protected $debitAccount = 'sales';


    protected $fillable = [
      'user_id',
      'team_id',
      'classroom_id',
      'grade_id',
      'level_id',
      'period_id',
      'client_id',
      'student_id',
      'date',
      'next_invoice_date',
      'status',
      'generated_invoice_dates',
      'first_invoice_date',
      'student_name',
      'parents_names',
      'end_date',
      'fee',
      'notes',
      'late_fee',
      'late_fee_type',
      'grace_days',
    ];

    protected $casts = [
      'generated_invoice_dates' => 'array'
    ];

    protected $table = "ac_admissions";

    protected static function boot() {
      parent::boot();
      static::creating(function ($admission) {
        $admission->next_invoice_date = $admission->next_invoice_date ?? $admission->first_invoice_date;
        $admission->client_id = $admission->student_id;
      });

      static::saving(function ($admission) {
        $parents = $admission->student->parents->pluck('display_name')->all() ?? [];

        $admission->client_id = $admission->student_id;
        $admission->level_id = $admission->classroom->level_id;
        $admission->grade_id = $admission->classroom->grade_id;
        $admission->grade_name = "{$admission->classroom->grade->full_name}";
        $admission->student_name = $admission->student->display_name;
        $admission->parents_names = implode(",", $parents);
      });
    }

    public function period() {
      return $this->belongsTo(AcademicPeriod::class, 'period_id');
    }
    public function grade() {
      return $this->belongsTo(Grade::class, 'grade_id');
    }
    public function classroom() {
      return $this->belongsTo(ClassRoom::class, 'classroom_id');
    }

    public function schedule() {
      return $this->morphMany(ResourceSchedule::class, 'scheduleable');
    }

    public function student() {
      return $this->belongsTo(Client::class, 'student_id');
    }

    public function parents() {
      return $this->hasManyThrough(Client::class, ContactRelation::class, 'related_contact_id', 'id', 's');
    }

    public function progress() {
      return $this->hasOne(StudentProgress::class);
    }

    public function client() {
      return $this->belongsTo(Client::class);
    }

    public function invoices() {
      return $this->morphMany(Invoice::class, 'invoiceable')
      ->orderBy('due_date', 'desc');
    }

    public function invoiceNotes() {
      return $this->morphMany(Invoice::class, 'invoiceable')->where('type', Invoice::DOCUMENT_TYPE_CREDIT_NOTE);
    }

    public function postExpirationInvoices() {
      return $this->invoices()
      ->where('due_date', '>', $this->end_date)
      ->get();
    }

    // scopes
    public function scopeActive($query)
    {
        return $query->whereIn('status', [
            self::STATUS_IN_PROGRESS,
            self::STATUS_COMPLETED,
        ]);
    }

    // transactionable implementation
    public function getTransactionItems() {
      return [];
    }

    public static function getCategoryName($payable): string {
      return "expected_payments_customers";
    }

    public function getTransactionDescription() {
      return "Deposito de propiedad " . $this->address;
    }

    public function getTransactionDirection(): string {
      return Transaction::DIRECTION_CREDIT;
    }

    public function getAccountId() {
      return $this->account_id;
    }

    public function getCounterAccountId(): int {
      return $this->client_account_id;
    }

    // payment things
    public function getStatusField(): string {
      return 'payment_status';
    }

    public static function calculateTotal($payable) {
      $payable->total = $payable->invoices()->sum('total');
    }

    public static function checkStatus($payable) {
      $debt = $payable->total - $payable->amount_paid;
      if ($payable->status == self::PAYMENT_STATUS_EXPIRED) {
        $status = $payable->status;
      } else if ($debt > 0 && $debt < $payable->amount) {
        $status = self::PAYMENT_STATUS_PARTIALLY_PAID;
      } elseif ($debt && $payable->hasLateInvoices()) {
        $status = self::PAYMENT_STATUS_LATE;
      } elseif ($debt == 0 && !$payable->cancelled_at) {
        $status = self::PAYMENT_STATUS_ACTIVE;
      } elseif ($payable->cancelled_at) {
        $status = self::PAYMENT_STATUS_CANCELLED;
      } else {
        $status = $payable->status;
      }
      return $status;
    }

    public function getConceptLine(): string {
        return "";
    }

    public function getTotalField($formData = []) {
      return 'total';
    }

    public function getTotal($formData = []) {
      return $this->invoices()->sum('total');
    }

    public function isActive() {
      return array_search($this->status, [
        self::PAYMENT_STATUS_ACTIVE,
        self::PAYMENT_STATUS_GRACE,
        self::PAYMENT_STATUS_LATE,
        self::PAYMENT_STATUS_PARTIALLY_PAID,
        self::PAYMENT_STATUS_PAID,
      ]);
    }

    protected static function newFactory()
    {
        return AdmissionFactory::new();
    }
}
