import {$, config, Router} from './bootstrap';

import common from './routes/common';
import home from './routes/home';
import business from './routes/business';
import merchandise from './routes/merchandise';
import move from './routes/move';
import service from './routes/service';
import faq from './routes/faq';
import jobs from './routes/jobs';
import manage from './routes/manage';
import pickup from './routes/pickup';
import billing from './routes/billing';
import order from './routes/order';
import account from './routes/account';
import sponsorship from './routes/sponsorship';
import pricing from './routes/pricing';

const routes = new Router({
    common,
    tplPagesHome: home,
    tplPagesBusiness: business,
    tplPagesMerchandise: merchandise,
    tplPagesMove: move,
    tplPagesService: service,
    tplPagesFaq: faq,
    tplPagesJobs: jobs,
    tplPagesPricing: pricing,
    tplProfileManage: manage,
    tplUserPickup: pickup,
    tplUserBilling: billing,
    // @TODO - Clean those routes
    tplOrderCalculator: order,
    tplOrderStorage: order,
    tplOrderServices: order,
    tplOrderAppointment: order,
    tplOrderBilling: order,
    tplOrderReview: order,
    // @TODO - Clean those routes
    tplProfileAccount: account,
    tplProfileSponsorship: sponsorship,
}, config);

$(document).ready(() => routes.loadEvents());
