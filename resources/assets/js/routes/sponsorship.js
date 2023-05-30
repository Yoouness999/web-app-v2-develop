import {debug} from '../bootstrap';
import profileSponsorship from '../components/sponsorship';

export default {
    load() {
        debug.bench('tpl_profile_sponsorship:load');

        profileSponsorship();
    },
};