<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 *
 * @property string $id
 * @property string $description
 * @property string $street
 * @property string $neighborhood
 * @property string $city
 * @property string $state
 * @property string $zip_code
 * @property string $person_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder<static>|Address newModelQuery()
 * @method static Builder<static>|Address newQuery()
 * @method static Builder<static>|Address query()
 * @method static Builder<static>|Address whereCity($value)
 * @method static Builder<static>|Address whereCreatedAt($value)
 * @method static Builder<static>|Address whereDescription($value)
 * @method static Builder<static>|Address whereId($value)
 * @method static Builder<static>|Address whereNeighborhood($value)
 * @method static Builder<static>|Address wherePersonId($value)
 * @method static Builder<static>|Address whereState($value)
 * @method static Builder<static>|Address whereStreet($value)
 * @method static Builder<static>|Address whereUpdatedAt($value)
 * @method static Builder<static>|Address whereZipCode($value)
 * @mixin \Eloquent
 */
class Address extends Model
{
    use HasUlids;

    protected $table = 'addresses';
    protected $fillable = [
        'street',
        'neighborhood',
        'city',
        'state',
        'zip_code',
        'person_id',
        'description',
    ];

    public $incrementing = false;
}
