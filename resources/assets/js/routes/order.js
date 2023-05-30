import {debug} from '../bootstrap';
import {orderIncrementInput, orderResumeBlock, orderStorage, orderCalculator, orderServices, orderAppointment, orderBilling, orderReview, cardTest} from '../components/order';

export default {
    load() {
        debug.bench('pickup:load');

        orderIncrementInput();
        orderResumeBlock();
        orderStorage();
        orderCalculator();
        orderServices();
        orderAppointment();
        orderBilling();
        orderReview();
        cardTest();
    },
};
