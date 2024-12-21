<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 *
 * @property string $id
 * @property string $first_name
 * @property string $last_name
 * @property string $entity_type
 * @property string|null $document
 * @property string|null $document_type
 * @property string|null $birth_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read Collection<int, Address> $addresses
 * @property-read int|null $addresses_count
 * @property-read Collection<int, Contact> $contacts
 * @property-read Collection<int, CarsModel> $cars
 * @property-read int|null $contacts_count
 * @method static Builder<static>|Client newModelQuery()
 * @method static Builder<static>|Client newQuery()
 * @method static Builder<static>|Client query()
 * @method static Builder<static>|Client whereBirthDate($value)
 * @method static Builder<static>|Client whereCreatedAt($value)
 * @method static Builder<static>|Client whereDeletedAt($value)
 * @method static Builder<static>|Client whereDocument($value)
 * @method static Builder<static>|Client whereDocumentType($value)
 * @method static Builder<static>|Client whereEntityType($value)
 * @method static Builder<static>|Client whereFirstName($value)
 * @method static Builder<static>|Client whereId($value)
 * @method static Builder<static>|Client whereLastName($value)
 * @method static Builder<static>|Client whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Client extends Model
{
    use HasUlids;
    use softDeletes;
    use HasFactory;

    protected $table = 'clients';
    protected $fillable = [
        'first_name',
        'last_name',
        'entity_type',
        'document',
        'document_type',
        'birth_date',
    ];

    protected $hidden = [
        'created_at',
        'deleted_at',
        'updated_at',
    ];

    public $incrementing = false;

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class, 'person_id', 'id');
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class, 'person_id', 'id');
    }

    public function cars(): BelongsToMany
    {
        return $this->belongsToMany(
            CarsModel::class,
            'client_cars',
            'client_id',
            'car_id'
        );
    }
}
