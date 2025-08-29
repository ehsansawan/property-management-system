<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $property_id
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property bool $is_active
 * @property int $views
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Property $property
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Review> $reviews
 * @property-read int|null $reviews_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad wherePropertyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad whereViews($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperAd {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $floor
 * @property int $rooms
 * @property int $bedrooms
 * @property int $bathrooms
 * @property bool $has_elevator
 * @property bool $has_alternative_power
 * @property bool $has_garage
 * @property bool $furnished
 * @property string|null $furnished_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Property|null $property
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Apartment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Apartment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Apartment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Apartment whereBathrooms($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Apartment whereBedrooms($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Apartment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Apartment whereFloor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Apartment whereFurnished($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Apartment whereFurnishedType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Apartment whereHasAlternativePower($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Apartment whereHasElevator($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Apartment whereHasGarage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Apartment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Apartment whereRooms($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Apartment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperApartment {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $property_id
 * @property string $date
 * @property string $time
 * @property string $status
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment wherePropertyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperAppointment {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $blocker_id
 * @property int $blocked_id
 * @property string $start_date
 * @property string $end_date
 * @property string|null $reason
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $blocked
 * @property-read \App\Models\User $blocker
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Block newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Block newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Block onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Block query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Block whereBlockedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Block whereBlockerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Block whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Block whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Block whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Block whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Block whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Block whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Block whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Block withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Block withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperBlock {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $governorate_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Governorate $governorate
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Location> $locations
 * @property-read int|null $locations_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereGovernorateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperCity {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $ad_id
 * @property-read \App\Models\Ad $ad
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favorite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favorite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favorite query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favorite whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favorite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favorite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favorite whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favorite whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperFavorite {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\City> $cities
 * @property-read int|null $cities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SuggestedLocation> $suggestedLocations
 * @property-read int|null $suggested_locations_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Governorate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Governorate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Governorate query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Governorate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Governorate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Governorate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Governorate whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperGovernorate {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $property_id
 * @property string|null $image_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Property $property
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image wherePropertyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperImage {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $type
 * @property bool $is_inside_master_plan
 * @property bool $is_serviced
 * @property string|null $slope
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Property|null $property
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Land newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Land newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Land query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Land whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Land whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Land whereIsInsideMasterPlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Land whereIsServiced($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Land whereSlope($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Land whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Land whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperLand {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $city_id
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\City $city
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Property> $property
 * @property-read int|null $property_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperLocation {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $body
 * @property string $type
 * @property int $is_read
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereIsRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperNotification {}
}

namespace App\Models{
/**
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotifyMe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotifyMe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotifyMe query()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperNotifyMe {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $floor
 * @property int $rooms
 * @property int $bathrooms
 * @property int $meeting_rooms
 * @property bool $has_parking
 * @property bool $furnished
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Property|null $property
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Office newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Office newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Office query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Office whereBathrooms($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Office whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Office whereFloor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Office whereFurnished($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Office whereHasParking($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Office whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Office whereMeetingRooms($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Office whereRooms($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Office whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperOffice {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $features
 * @property int $duration
 * @property string $type
 * @property string $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Subscription|null $subscriptions
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereFeatures($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperPlan {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $gender
 * @property string $phone_number
 * @property string|null $image_url
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperProfile {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int|null $area
 * @property float|null $price
 * @property string|null $name
 * @property string|null $description
 * @property int|null $propertyable_id
 * @property string|null $propertyable_type
 * @property bool $is_ad
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $address
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ad|null $Ad
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Appointment> $appointments
 * @property-read int|null $appointments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Image> $images
 * @property-read int|null $images_count
 * @property-read \App\Models\Location|null $location
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent|null $propertyable
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereIsAd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property wherePropertyableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property wherePropertyableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperProperty {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $ad_id
 * @property string $reason
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ad $ad
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperReport {}
}

namespace App\Models{
/**
 * @property string $email
 * @property string $code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResetCodePassword newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResetCodePassword newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResetCodePassword query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResetCodePassword whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResetCodePassword whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResetCodePassword whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResetCodePassword whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperResetCodePassword {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $rating
 * @property string $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $ad_id
 * @property-read \App\Models\Ad $ad
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperReview {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $floor
 * @property string $type
 * @property bool $has_warehouse
 * @property bool $has_bathroom
 * @property bool $has_ac
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Property|null $property
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop whereFloor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop whereHasAc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop whereHasBathroom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop whereHasWarehouse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperShop {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $plan_id
 * @property string $start_date
 * @property string $end_date
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Plan $plan
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription wherePlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperSubscription {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $user_id
 * @property int $governorate_id
 * @property string $city_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Governorate $governorate
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuggestedLocation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuggestedLocation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuggestedLocation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuggestedLocation whereCityName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuggestedLocation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuggestedLocation whereGovernorateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuggestedLocation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuggestedLocation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuggestedLocation whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperSuggestedLocation {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $last_name
 * @property string $email
 * @property string $phone_number
 * @property string|null $fcm_token
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $first_name
 * @property int $has_active_subscription
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Ad> $ads
 * @property-read int|null $ads_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Appointment> $appointments
 * @property-read int|null $appointments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Block> $blockedBy
 * @property-read int|null $blocked_by_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Block> $blocks
 * @property-read int|null $blocks_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Favorite> $favorites
 * @property-read int|null $favorites_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Notification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \App\Models\Profile|null $profile
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Property> $properties
 * @property-read int|null $properties_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Review> $reviews
 * @property-read int|null $reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Subscription> $subscriptions
 * @property-read int|null $subscriptions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SuggestedLocation> $suggestedLocations
 * @property-read int|null $suggested_locations_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFcmToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereHasActiveSubscription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUser {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property array<array-key, mixed>|null $filters
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSearches newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSearches newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSearches query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSearches whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSearches whereFilters($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSearches whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSearches whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSearches whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUserSearches {}
}

