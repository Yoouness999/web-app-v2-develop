import {debug, config} from '../bootstrap';
import Pickup from '../components/pickup';

export default {
    load() {
        debug.bench('pickup:load');

        // add pickup module declaration
        config.dependencies.push('pickup');
    },
};