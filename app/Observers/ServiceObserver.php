<?php

namespace App\Observers;

use App\Models\Service;

class ServiceObserver 
{
    public function updating(Service $service)
    {
    	if(!$service->enabled)
		{
			foreach($service->keys as $key)
			{
				$key->update(['enabled' => 0]);
			}
		}
    }

    public function deleting(Service $service)
    {
    	$service->teams()->detach();
    	foreach($service->keys as $key)
        {
            $key->delete();
        }
    }
}