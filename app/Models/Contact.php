<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 *
 * @property string $id
 * @property string $type
 * @property string $contact
 * @property string $person_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder<static>|Contact newModelQuery()
 * @method static Builder<static>|Contact newQuery()
 * @method static Builder<static>|Contact query()
 * @method static Builder<static>|Contact whereContact($value)
 * @method static Builder<static>|Contact whereCreatedAt($value)
 * @method static Builder<static>|Contact whereId($value)
 * @method static Builder<static>|Contact wherePersonId($value)
 * @method static Builder<static>|Contact whereType($value)
 * @method static Builder<static>|Contact whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Contact extends Model
{
    use HasUlids;

    protected $table = 'contacts';
    protected $fillable = [
        'type',
        'contact',
        'person_id',
    ];

    public $incrementing = false;
}
