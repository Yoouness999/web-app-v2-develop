import {debug} from '../bootstrap';
import account from '../components/account';
import {cardTest} from '../components/order';

export default {
    load() {
        debug.bench('tpl_profile_account:load');

        account.profileCommon();
        account.profileInformations();
        account.profileBilling();
        account.profilePassword();

        cardTest();
    },
};
