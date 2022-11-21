<?php

namespace PlaneLogixAPI\Laravel\Facades;

use Illuminate\Support\Facades\Facade;
use PlaneLogixAPI\Api\Aircraft;
use PlaneLogixAPI\Api\Documents;
use PlaneLogixAPI\Api\Logbooks;
use PlaneLogixAPI\Api\MaintenanceRecords;
use PlaneLogixAPI\Api\Squawks;
use PlaneLogixAPI\Api\TrackingItems;

/**
 * Facade for the PlaneLogixAPI service
 *
 * @method static Aircraft aircraft() Get the aircraft API
 * @method static Documents documents() Get the documents API
 * @method static Logbooks logbooks() Get the logbooks API
 * @method static MaintenanceRecords maintenanceRecords() Get the maintenance records API
 * @method static Squawks squawks() Get the squawks API
 * @method static TrackingItems trackingItems() Get the tracking items API
 */
class PlaneLogixAPI extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'planelogix';
    }
}
