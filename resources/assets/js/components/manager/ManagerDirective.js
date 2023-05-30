import $ from 'jquery';

/**
 * Not used for now
 */
class BoxItemDirective {

    constructor() {
        this.scope = {
            box:  '=boxModel',
            type: '=boxType',
        };

        this.restrict = 'E';

        this.controllerAs = 'ctrl';
        // allow to use `this` instead of `$scope` in controller
        this.bindToController = true;

        this.template =
            `<div class="card-box animated fadeInDown">
	    		<div class="row">
	    			<div class="col-sm-2">
	    				<img ng-src="/assets/img/item-box.jpg" alt="{{ ::ctrl.box.type }}">
					</div>
					<div class="col-sm-6" ng-if="ctrl.box.status == 'STORED' || ctrl.box.status == 'DROPPED' || ctrl.box.status == 'INDEXED'">
						<p class="item-title">{{ ::ctrl.box.name }}</p>
						<p class="item-description">#{{ ::ctrl.box.id }} - Stored on {{ ::ctrl.box.storage_date | momentDate : ' D/M/YYYY' }}</p>
					</div>
					<div class="col-sm-6" ng-if="ctrl.box.status == 'TRANSIT' || ctrl.box.status == 'CREATE' || ctrl.box.status == 'PICKED-UP'">
						<p class="item-title">New item being processed{{ ::ctrl.box.name }}</p>
						<p class="item-description">
							<i class="fa fa-clock-o"></i> Scheduled for {{ ::ctrl.box.pickup_date | momentDate : 'dddd D/M/YYYY hA' }}-{{ ::ctrl.box.pickup_date | momentDate : 'hA' : 2 : 'h' }}
						</p>
						<p class="item-description">
							<i class="fa fa-home"></i>  {{ ::ctrl.box.street }}  {{ ::ctrl.box.number }},  {{ ::ctrl.box.postalcode }} {{ ::ctrl.box.city }}
						</p>
					</div>
					<div class="col-sm-6" ng-if="ctrl.box.status == 'DELIVERED'">
						<p class="item-title">{{ ::ctrl.box.name }}</p>
						<p class="item-description">Scheduled on {{ ::ctrl.box.pickup_date | momentDate : 'dddd D/M/YYYY hA' }}-{{ ::ctrl.box.pickup_date | momentDate : 'hA' : 2 : 'h' }}</p>
					</div>
					<div class="col-sm-4">
						<div ng-if="ctrl.box.status == 'in_storage'">
							<button type="button" class="btn btn-default btn-block btn-xs" ng-class="{true: 'disabled'}[!box.photos.length]" ng-click="ctrl.openGallery()">{{ ::ctrl.box.photos.length }} photo</button>
							<a href="#" class="btn btn-primary btn-block btn-xs">Send back</a>
						</div>
						<div ng-if="ctrl.box.status == 'ORDERED' || ctrl.box.status == 'READY' || ctrl.box.status == 'TRANSIT' || ctrl.box.status == 'DELIVERED'">
							<a href="#" class="btn btn-primary btn-block btn-xs">Reschedule a pickup</a>
							<a href="#" class="btn btn-primary btn-block btn-xs">Update address</a>
						</div>
					</div>
				</div>
	    	</div>`;
    }


    /**
     * @ngInject
     */
    controller() {
        class BoxItemController {
            getButtonText() {
                return this.type === 'in_storage' ? 'Send back' : 'Schedule a pickup';
            }

            openGallery() {
                let photos = this.box.photos;
                let photosArr = [];

                if (!photos.length) { return; }

                for (let i = photos.length - 1; i >= 0; i--) {
                    photosArr.push({
                        href:  photos[i],
                        title: '',
                    });
                }

                $.fancybox.open(photosArr, {
                    // options
                });
            }
        }

        return new BoxItemController();
    }

    link(scope, element) {

    }
}


export default function BoxItem() {
    return new BoxItemDirective();
}
