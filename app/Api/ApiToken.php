<?php
namespace App\Api;

use Illuminate\Database\Eloquent\Model;
use Config;
use Datetime;

class ApiToken extends Model {
	protected $dates = ['created_at', 'updated_at'];
	
	const TYPE_REQUEST = 'request';
	const TYPE_ACCESS = 'access';
	const TYPE_REFRESH = 'refresh';
	
	////////////////
	// Relationships
	////////////////
	
	public function app() {
        return $this->belongsTo('App\Api\ApiApp', 'api_apps_id');
    }
	
	public function user() {
        return $this->belongsTo('App\User');
    }
	
	public function arxminUser() {
        return $this->belongsTo('App\ArxminUser');
    }
	
	////////////////
	// Helpers
	////////////////
	
	public function setToken() {
		$this->token = bcrypt(time());
	}
	
	public function isClientAccess() {
		return $this->user()->first();
	}
	
	public function isTransporterAccess() {
		return $this->arxminUser()->first();
	}
	
	public function getUser() {
		if ($this->isClientAccess()) {
			return $this->user()->first();
		} elseif ($this->isTransporterAccess()) {
			return $this->arxminUser()->first();
		}
		
		return null;
	}

    public function getExpirationDate() {

        $expire_at = clone($this->created_at);

        switch ($this->type) {
            case Self::TYPE_REQUEST:
                $expire_at->modify('+' . Config::get('app.boxify_api.token_lifetime.request') . ' minute');
                break;
            case Self::TYPE_ACCESS:
                if ($this->isClientAccess()) {
                    $expire_at->modify('+' . Config::get('app.boxify_api.token_lifetime.access_client') . ' minute');
                }

                if ($this->isTransporterAccess()) {
                    $expire_at->modify('+' . Config::get('app.boxify_api.token_lifetime.access_transporter') . ' minute');
                }
            case Self::TYPE_REFRESH:
                $expire_at->modify('+' . Config::get('app.boxify_api.token_lifetime.refresh') . ' minute');
                break;
        }

        return $expire_at;
    }
	
	public function isValid() {
		$now = new DateTime();
		$expire_at = $this->getExpirationDate();
		return $expire_at >= $now;
	}
}