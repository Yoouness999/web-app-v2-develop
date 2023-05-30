import {debug, config} from '../bootstrap';
import Manager from '../components/manager';

export default {
    load() {
        debug.bench('tpl_profile_manager:load');

        config.dependencies.push('manager');
    },
};