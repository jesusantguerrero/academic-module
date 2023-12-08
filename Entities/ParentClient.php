<?php

namespace Modules\Academic\Entities;

use App\Domains\CRM\Models\Client;

class ParentClient extends Client
{
  public function childs() {
    return $this->belongsToMany(
      Client::class,
      'contact_relations',
      'related_contact_id',
      'contact_id',
    );
  }
  
  protected $table = 'clients';
}
