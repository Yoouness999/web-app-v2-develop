import {$, debug} from '../bootstrap';
import order from '../routes/order';

export default {
    load() {
        debug.bench('pricing:load');

        // @note Run another module/route
        order.load();

    },
};