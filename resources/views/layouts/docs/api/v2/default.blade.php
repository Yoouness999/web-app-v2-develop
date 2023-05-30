<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        @include('includes.docs.api.v2.head')
    </head>
    <body>

        <div class="container">
            <div class="row">
                <div class="col-3" id="sidebar">
                    <div class="column-content">
                        <div class="search-header">
                            <img src="/assets/img/logo.png" class="logo" alt="Logo" />
                            <input id="search" type="text" placeholder="Search">
                        </div>
                        <ul id="navigation">

                            <li><a href="#introduction">Introduction</a></li>

                            

                            <li>
                                <a href="#ApiCoupons">ApiCoupons</a>
                                <ul>
									<li><a href="#ApiCoupons_get">get</a></li>

									<li><a href="#ApiCoupons_add">add</a></li>

									<li><a href="#ApiCoupons_save">save</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiUnavailableDates">ApiUnavailableDates</a>
                                <ul>
									<li><a href="#ApiUnavailableDates_get">get</a></li>

									<li><a href="#ApiUnavailableDates_add">add</a></li>

									<li><a href="#ApiUnavailableDates_save">save</a></li>

									<li><a href="#ApiUnavailableDates_delete">delete</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiPosts">ApiPosts</a>
                                <ul>
									<li><a href="#ApiPosts_get">get</a></li>

									<li><a href="#ApiPosts_add">add</a></li>

									<li><a href="#ApiPosts_save">save</a></li>

									<li><a href="#ApiPosts_delete">delete</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiEventGuests">ApiEventGuests</a>
                                <ul>
									<li><a href="#ApiEventGuests_get">get</a></li>

									<li><a href="#ApiEventGuests_add">add</a></li>

									<li><a href="#ApiEventGuests_save">save</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiEvents">ApiEvents</a>
                                <ul>
									<li><a href="#ApiEvents_get">get</a></li>

									<li><a href="#ApiEvents_add">add</a></li>

									<li><a href="#ApiEvents_save">save</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiFees">ApiFees</a>
                                <ul>
									<li><a href="#ApiFees_getList">getList</a></li>

									<li><a href="#ApiFees_add">add</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiHistoricals">ApiHistoricals</a>
                                <ul>
									<li><a href="#ApiHistoricals_get">get</a></li>

									<li><a href="#ApiHistoricals_add">add</a></li>

									<li><a href="#ApiHistoricals_save">save</a></li>

									<li><a href="#ApiHistoricals_delete">delete</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiHistoricalCategories">ApiHistoricalCategories</a>
                                <ul>
									<li><a href="#ApiHistoricalCategories_get">get</a></li>

									<li><a href="#ApiHistoricalCategories_add">add</a></li>

									<li><a href="#ApiHistoricalCategories_save">save</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiInvoices">ApiInvoices</a>
                                <ul>
									<li><a href="#ApiInvoices_get">get</a></li>

									<li><a href="#ApiInvoices_add">add</a></li>

									<li><a href="#ApiInvoices_save">save</a></li>

									<li><a href="#ApiInvoices_delete">delete</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiItems">ApiItems</a>
                                <ul>
									<li><a href="#ApiItems_get">get</a></li>

									<li><a href="#ApiItems_add">add</a></li>

									<li><a href="#ApiItems_save">save</a></li>

									<li><a href="#ApiItems_types">types</a></li>

									<li><a href="#ApiItems_statuses">statuses</a></li>

									<li><a href="#ApiItems_pickupOptions">pickupOptions</a></li>

									<li><a href="#ApiItems_removeFile">removeFile</a></li>

									<li><a href="#ApiItems_delete">delete</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiPickups">ApiPickups</a>
                                <ul>
									<li><a href="#ApiPickups_get">get</a></li>

									<li><a href="#ApiPickups_add">add</a></li>

									<li><a href="#ApiPickups_save">save</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiTodos">ApiTodos</a>
                                <ul>
									<li><a href="#ApiTodos_get">get</a></li>

									<li><a href="#ApiTodos_add">add</a></li>

									<li><a href="#ApiTodos_save">save</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiUsers">ApiUsers</a>
                                <ul>
									<li><a href="#ApiUsers_get">get</a></li>

									<li><a href="#ApiUsers_add">add</a></li>

									<li><a href="#ApiUsers_save">save</a></li>

									<li><a href="#ApiUsers_cities">cities</a></li>

									<li><a href="#ApiUsers_login">login</a></li>

									<li><a href="#ApiUsers_delete">delete</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiOrderAnswers">ApiOrderAnswers</a>
                                <ul>
									<li><a href="#ApiOrderAnswers_get">get</a></li>

									<li><a href="#ApiOrderAnswers_add">add</a></li>

									<li><a href="#ApiOrderAnswers_save">save</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiAreas">ApiAreas</a>
                                <ul>
									<li><a href="#ApiAreas_get">get</a></li>

									<li><a href="#ApiAreas_add">add</a></li>

									<li><a href="#ApiAreas_save">save</a></li>

									<li><a href="#ApiAreas_delete">delete</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiOrderAssurances">ApiOrderAssurances</a>
                                <ul>
									<li><a href="#ApiOrderAssurances_get">get</a></li>

									<li><a href="#ApiOrderAssurances_add">add</a></li>

									<li><a href="#ApiOrderAssurances_save">save</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiOrderBookings">ApiOrderBookings</a>
                                <ul>
									<li><a href="#ApiOrderBookings_get">get</a></li>

									<li><a href="#ApiOrderBookings_add">add</a></li>

									<li><a href="#ApiOrderBookings_save">save</a></li>

									<li><a href="#ApiOrderBookings_delete">delete</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiOrderBookingStatuses">ApiOrderBookingStatuses</a>
                                <ul>
									<li><a href="#ApiOrderBookingStatuses_get">get</a></li>

									<li><a href="#ApiOrderBookingStatuses_add">add</a></li>

									<li><a href="#ApiOrderBookingStatuses_save">save</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiOrderCalculatorCategories">ApiOrderCalculatorCategories</a>
                                <ul>
									<li><a href="#ApiOrderCalculatorCategories_get">get</a></li>

									<li><a href="#ApiOrderCalculatorCategories_add">add</a></li>

									<li><a href="#ApiOrderCalculatorCategories_save">save</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiOrderCalculatorItems">ApiOrderCalculatorItems</a>
                                <ul>
									<li><a href="#ApiOrderCalculatorItems_get">get</a></li>

									<li><a href="#ApiOrderCalculatorItems_add">add</a></li>

									<li><a href="#ApiOrderCalculatorItems_save">save</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiOrderPlanAssets">ApiOrderPlanAssets</a>
                                <ul>
									<li><a href="#ApiOrderPlanAssets_get">get</a></li>

									<li><a href="#ApiOrderPlanAssets_add">add</a></li>

									<li><a href="#ApiOrderPlanAssets_save">save</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiOrderPlanCategories">ApiOrderPlanCategories</a>
                                <ul>
									<li><a href="#ApiOrderPlanCategories_get">get</a></li>

									<li><a href="#ApiOrderPlanCategories_add">add</a></li>

									<li><a href="#ApiOrderPlanCategories_save">save</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiOrderPlans">ApiOrderPlans</a>
                                <ul>
									<li><a href="#ApiOrderPlans_get">get</a></li>

									<li><a href="#ApiOrderPlans_add">add</a></li>

									<li><a href="#ApiOrderPlans_save">save</a></li>

									<li><a href="#ApiOrderPlans_delete">delete</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiOrderPlanRegion">ApiOrderPlanRegion</a>
                                <ul>
									<li><a href="#ApiOrderPlanRegion_get">get</a></li>

									<li><a href="#ApiOrderPlanRegion_add">add</a></li>

									<li><a href="#ApiOrderPlanRegion_save">save</a></li>

									<li><a href="#ApiOrderPlanRegion_delete">delete</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiOrderQuestions">ApiOrderQuestions</a>
                                <ul>
									<li><a href="#ApiOrderQuestions_get">get</a></li>

									<li><a href="#ApiOrderQuestions_add">add</a></li>

									<li><a href="#ApiOrderQuestions_save">save</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiRegions">ApiRegions</a>
                                <ul>
									<li><a href="#ApiRegions_get">get</a></li>

									<li><a href="#ApiRegions_add">add</a></li>

									<li><a href="#ApiRegions_save">save</a></li>

									<li><a href="#ApiRegions_delete">delete</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiOrderStoringDurations">ApiOrderStoringDurations</a>
                                <ul>
									<li><a href="#ApiOrderStoringDurations_get">get</a></li>

									<li><a href="#ApiOrderStoringDurations_add">add</a></li>

									<li><a href="#ApiOrderStoringDurations_save">save</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiWarehouses">ApiWarehouses</a>
                                <ul>
									<li><a href="#ApiWarehouses_get">get</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiNotifications">ApiNotifications</a>
                                <ul>
									<li><a href="#ApiNotifications_get">get</a></li>

									<li><a href="#ApiNotifications_add">add</a></li>

									<li><a href="#ApiNotifications_save">save</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiArxminUsers">ApiArxminUsers</a>
                                <ul>
									<li><a href="#ApiArxminUsers_get">get</a></li>

									<li><a href="#ApiArxminUsers_add">add</a></li>

									<li><a href="#ApiArxminUsers_save">save</a></li>

									<li><a href="#ApiArxminUsers_delete">delete</a></li>

									<li><a href="#ApiArxminUsers_login">login</a></li>

									<li><a href="#ApiArxminUsers_permissions">permissions</a></li>

									<li><a href="#ApiArxminUsers_reset">reset</a></li>
</ul>
                            </li>


                        </ul>
                    </div>
                </div>
                <div class="col-9" id="main-content">

                    <div class="column-content">

                        @include('includes.docs.api.v2.introduction')

                        <hr />

                                                

                                                <a href="#" class="waypoint" name="ApiCoupons"></a>
                        <h2>ApiCoupons</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiCoupons_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v2/coupons</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get coupons.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/coupons" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiCoupons_add"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>add</h3></li>
                            <li>api/v2/coupons</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Add a coupon.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/coupons" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">Request$request</div>
                                <div class="parameter-type">\Request</div>
                                <div class="parameter-desc"></div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="Request$request">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiCoupons_save"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>save</h3></li>
                            <li>api/v2/coupons</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Save a coupon.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/coupons" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">Request$request</div>
                                <div class="parameter-type">\Request</div>
                                <div class="parameter-desc"></div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="Request$request">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiUnavailableDates"></a>
                        <h2>ApiUnavailableDates</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiUnavailableDates_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v2/unavailable-dates</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get unaivalables dates</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/unavailable-dates" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiUnavailableDates_add"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>add</h3></li>
                            <li>api/v2/unavailable-dates</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Add a unaivalable date.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/unavailable-dates" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">date</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="date">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiUnavailableDates_save"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>save</h3></li>
                            <li>api/v2/unavailable-dates</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Save an unaivalable date.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/unavailable-dates" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">id of the unaivalable date.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">date</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="date">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiUnavailableDates_delete"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>DELETE</h2></li>
                            <li><h3>delete</h3></li>
                            <li>api/v2/unavailable-dates</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Delete an unaivalable date.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/unavailable-dates" type="DELETE">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="DELETE"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiPosts"></a>
                        <h2>ApiPosts</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiPosts_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v2/posts</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get posts</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/posts" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiPosts_add"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>add</h3></li>
                            <li>api/v2/posts</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Add a post.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/posts" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">slug</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) : slug of the post</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="slug">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">title</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) : title of the post (for email = subject of the email)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="title">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">text$content</div>
                                <div class="parameter-type">\text</div>
                                <div class="parameter-desc">(required) : text field representing the content in html format</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="text$content">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">ref</div>
                                <div class="parameter-type">integer</div>
                                <div class="parameter-desc">(required) : the post id of reference (used when you translate a post in a different lang)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="ref">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">lang</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) : the lang of the post (fr,en or nl)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="lang">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">type</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) : type of post (actually the types are page, post and email</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="type">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">timestamp$updated_at</div>
                                <div class="parameter-type">\timestamp</div>
                                <div class="parameter-desc">(optionnal) : the updated date</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="timestamp$updated_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">json$meta</div>
                                <div class="parameter-type">\json</div>
                                <div class="parameter-desc">(optionnal) : meta custom fields in a json format (not used in boxify)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="json$meta">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">meta_type</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) : meta_type = type of custom meta (actually not used in boxify)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="meta_type">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">thumb</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) : the default thumb link (not used in boxify)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="thumb">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">json$version</div>
                                <div class="parameter-type">\json</div>
                                <div class="parameter-desc">(optionnal) : the version of the edition (not used)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="json$version">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">level</div>
                                <div class="parameter-type">integer</div>
                                <div class="parameter-desc">(optionnal) : hierarchical level of a post (deprecated)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="level">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">position</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">: position of the post for map (not used)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="position">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">json$categories</div>
                                <div class="parameter-type">\json</div>
                                <div class="parameter-desc">: (deprecated we use category_post table instead)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="json$categories">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">json$tags</div>
                                <div class="parameter-type">\json</div>
                                <div class="parameter-desc">: (deprecated)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="json$tags">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">status</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) : status of a post (published, draft, trashed) Not used in boxify</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="status">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">json$context</div>
                                <div class="parameter-type">\json</div>
                                <div class="parameter-desc">: custom json when you can put anything (not used)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="json$context">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">timestamp$created_at</div>
                                <div class="parameter-type">\timestamp</div>
                                <div class="parameter-desc"></div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="timestamp$created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">parent_id</div>
                                <div class="parameter-type">integer</div>
                                <div class="parameter-desc">: used to define hierarchy (@see : https://github.com/etrepat/baum)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="parent_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">lft</div>
                                <div class="parameter-type">integer</div>
                                <div class="parameter-desc">: used to define hierarchy (@see : https://github.com/etrepat/baum)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="lft">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">rgt</div>
                                <div class="parameter-type">integer</div>
                                <div class="parameter-desc">: used to define hierarchy (@see : https://github.com/etrepat/baum)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="rgt">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">depth</div>
                                <div class="parameter-type">integer</div>
                                <div class="parameter-desc">: used to define hierarchy (@see : https://github.com/etrepat/baum)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="depth">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">template</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">:  template to apply for the post (not used in boxify)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="template">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">timestamp$published_at</div>
                                <div class="parameter-type">\timestamp</div>
                                <div class="parameter-desc">: date of publication (not used)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="timestamp$published_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">is_public</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">: define if the post is public or not (not used)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="is_public">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">is_highlighted</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">: define if the post should be highlighted or not (not used)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="is_highlighted">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">json$logs</div>
                                <div class="parameter-type">\json</div>
                                <div class="parameter-desc">: not used</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="json$logs">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiPosts_save"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>save</h3></li>
                            <li>api/v2/posts</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Save an post.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/posts" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">id of the post.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">slug</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) : slug of the post</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="slug">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">title</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) : title of the post (for email = subject of the email)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="title">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">text$content</div>
                                <div class="parameter-type">\text</div>
                                <div class="parameter-desc">(required) : text field representing the content in html format</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="text$content">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">ref</div>
                                <div class="parameter-type">integer</div>
                                <div class="parameter-desc">(required) : the post id of reference (used when you translate a post in a different lang)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="ref">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">lang</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) : the lang of the post (fr,en or nl)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="lang">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">type</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) : type of post (actually the types are page, post and email</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="type">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">timestamp$updated_at</div>
                                <div class="parameter-type">\timestamp</div>
                                <div class="parameter-desc">(optionnal) : the updated date</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="timestamp$updated_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">json$meta</div>
                                <div class="parameter-type">\json</div>
                                <div class="parameter-desc">(optionnal) : meta custom fields in a json format (not used in boxify)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="json$meta">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">meta_type</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) : meta_type = type of custom meta (actually not used in boxify)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="meta_type">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">thumb</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) : the default thumb link (not used in boxify)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="thumb">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">json$version</div>
                                <div class="parameter-type">\json</div>
                                <div class="parameter-desc">(optionnal) : the version of the edition (not used)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="json$version">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">level</div>
                                <div class="parameter-type">integer</div>
                                <div class="parameter-desc">(optionnal) : hierarchical level of a post (deprecated)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="level">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">position</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">: position of the post for map (not used)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="position">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">json$categories</div>
                                <div class="parameter-type">\json</div>
                                <div class="parameter-desc">: (deprecated we use category_post table instead)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="json$categories">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">json$tags</div>
                                <div class="parameter-type">\json</div>
                                <div class="parameter-desc">: (deprecated)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="json$tags">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">status</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) : status of a post (published, draft, trashed) Not used in boxify</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="status">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">json$context</div>
                                <div class="parameter-type">\json</div>
                                <div class="parameter-desc">: custom json when you can put anything (not used)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="json$context">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">timestamp$created_at</div>
                                <div class="parameter-type">\timestamp</div>
                                <div class="parameter-desc"></div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="timestamp$created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">parent_id</div>
                                <div class="parameter-type">integer</div>
                                <div class="parameter-desc">: used to define hierarchy (@see : https://github.com/etrepat/baum)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="parent_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">lft</div>
                                <div class="parameter-type">integer</div>
                                <div class="parameter-desc">: used to define hierarchy (@see : https://github.com/etrepat/baum)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="lft">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">rgt</div>
                                <div class="parameter-type">integer</div>
                                <div class="parameter-desc">: used to define hierarchy (@see : https://github.com/etrepat/baum)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="rgt">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">depth</div>
                                <div class="parameter-type">integer</div>
                                <div class="parameter-desc">: used to define hierarchy (@see : https://github.com/etrepat/baum)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="depth">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">template</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">:  template to apply for the post (not used in boxify)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="template">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">timestamp$published_at</div>
                                <div class="parameter-type">\timestamp</div>
                                <div class="parameter-desc">: date of publication (not used)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="timestamp$published_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">is_public</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">: define if the post is public or not (not used)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="is_public">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">is_highlighted</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">: define if the post should be highlighted or not (not used)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="is_highlighted">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">json$logs</div>
                                <div class="parameter-type">\json</div>
                                <div class="parameter-desc">: not used</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="json$logs">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiPosts_delete"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>DELETE</h2></li>
                            <li><h3>delete</h3></li>
                            <li>api/v2/posts</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Delete an post.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/posts" type="DELETE">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="DELETE"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiEventGuests"></a>
                        <h2>ApiEventGuests</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiEventGuests_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v2/events/guests</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get event guests.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/events/guests" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiEventGuests_add"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>add</h3></li>
                            <li>api/v2/events/guests</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Add an event guest.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/events/guests" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">event_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Event.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="event_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">user_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) User, guest.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="user_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">user_type</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Guest type.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="user_type">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">accept</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Accept: 1 or 0.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="accept">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiEventGuests_save"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>save</h3></li>
                            <li>api/v2/events/guests</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Save an event guest.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/events/guests" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">event_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Event.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="event_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">user_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) User, guest.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="user_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">user_type</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Guest type.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="user_type">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">accept</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Accept: 1 or 0.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="accept">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiEvents"></a>
                        <h2>ApiEvents</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiEvents_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v2/events</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get events.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/events" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiEvents_add"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>add</h3></li>
                            <li>api/v2/events</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Add an event.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/events" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">title</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Title.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="title">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">location</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Location.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="location">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">date</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="date">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">notes</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Notes.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="notes">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiEvents_save"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>save</h3></li>
                            <li>api/v2/events</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Save an event.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/events" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">title</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Title.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="title">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">location</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Location.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="location">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">date</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="date">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">notes</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Notes.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="notes">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiFees"></a>
                        <h2>ApiFees</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiFees_getList"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>getList</h3></li>
                            <li>api/v2/fees</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get available fees list</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/fees" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="name">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">user_id</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Customer.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="user_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">item_id</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Item.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="item_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">type</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Type.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="type">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">ref</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Reference.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="ref">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">price</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Price.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="price">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">nb</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Quantity.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="nb">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">status</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Status: settlement_confirmed...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="status">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiFees_add"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>add</h3></li>
                            <li>api/v2/fees</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Add a fee AND generate an invoice of type = fees</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/fees" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="name">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">user_id</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Customer.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="user_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">item_id</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Item.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="item_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">type</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Type.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="type">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">ref</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Reference.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="ref">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">price</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Price.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="price">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">nb</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Quantity.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="nb">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">status</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Status: settlement_confirmed...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="status">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiHistoricals"></a>
                        <h2>ApiHistoricals</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiHistoricals_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v2/historicals</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get historicals.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/historicals" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiHistoricals_add"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>add</h3></li>
                            <li>api/v2/historicals</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Add a historical.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/historicals" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">user_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) User.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="user_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">historical_category_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Category.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="historical_category_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">title</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Title.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="title">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">description</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Description.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="description">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiHistoricals_save"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>save</h3></li>
                            <li>api/v2/historicals</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Save a historical.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/historicals" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">user_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) User.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="user_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">historical_category_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Category.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="historical_category_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">title</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Title.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="title">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">description</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Description.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="description">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiHistoricals_delete"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>DELETE</h2></li>
                            <li><h3>delete</h3></li>
                            <li>api/v2/historicals</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Delete a historical.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/historicals" type="DELETE">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="DELETE"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiHistoricalCategories"></a>
                        <h2>ApiHistoricalCategories</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiHistoricalCategories_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v2/historicals/categories</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get historical categories.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/historicals/categories" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiHistoricalCategories_add"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>add</h3></li>
                            <li>api/v2/historicals/categories</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Add a historical category.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/historicals/categories" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">slug</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Slug, unique.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="slug">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiHistoricalCategories_save"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>save</h3></li>
                            <li>api/v2/historicals/categories</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Save a historical category.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/historicals/categories" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">slug</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Slug, unique.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="slug">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiInvoices"></a>
                        <h2>ApiInvoices</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiInvoices_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v2/invoices</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get invoices.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/invoices" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiInvoices_add"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>add</h3></li>
                            <li>api/v2/invoices</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Add an invoice.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/invoices" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">number</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Number.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="number">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">title</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Title.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="title">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">content</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Content.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="content">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">price</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Type.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="price">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">user_id</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Reference.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="user_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">item_id</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Price.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="item_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">pickup_id</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Pickup.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="pickup_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">fee_id</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Fee.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="fee_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">status</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Status: paid, unpaid.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="status">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">attempt</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Attempt : 1 or 0.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="attempt">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">payment_date</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Payment date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="payment_date">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">payment_schedule</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Payment schedule.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="payment_schedule">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">billing_ref</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Billing reference.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="billing_ref">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">billing_type</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Billing type: fee...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="billing_type">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">billing_id</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Billing.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="billing_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">billing_exempted</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(required) Billing exempted: 1 or 0.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="billing_exempted">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">type</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Type</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="type">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiInvoices_save"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>save</h3></li>
                            <li>api/v2/invoices</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Save an invoice.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/invoices" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">number</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Number.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="number">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">title</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Title.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="title">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">content</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Content.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="content">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">price</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Type.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="price">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">user_id</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Reference.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="user_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">item_id</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Price.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="item_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">pickup_id</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Pickup.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="pickup_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">fee_id</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Fee.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="fee_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">status</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Status: paid, unpaid.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="status">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">attempt</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Attempt : 1 or 0.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="attempt">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">payment_date</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Payment date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="payment_date">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">payment_schedule</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Payment schedule.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="payment_schedule">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">billing_ref</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Billing reference.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="billing_ref">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">billing_type</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Billing type: fee...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="billing_type">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">billing_id</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Billing.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="billing_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">billing_exempted</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Billing exempted: 1 or 0.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="billing_exempted">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiInvoices_delete"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>DELETE</h2></li>
                            <li><h3>delete</h3></li>
                            <li>api/v2/invoices</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Delete an invoice</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/invoices" type="DELETE">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="DELETE"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiItems"></a>
                        <h2>ApiItems</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiItems_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v2/items</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get items.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/items" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiItems_add"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>add</h3></li>
                            <li>api/v2/items</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Add an item.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/items" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">user_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Customer.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="user_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">pickup_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Pickup.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="pickup_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">ref</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Reference.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="ref">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">type</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Type: bike, box, suitcase, fridge, other...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="type">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">status</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Status: with_me, in_storage, in_transit.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="status">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="name">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">description</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Description.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="description">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">file$photo</div>
                                <div class="parameter-type">\file</div>
                                <div class="parameter-desc">(optionnal) Photo.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="file$photo">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">weight</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Weight.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="weight">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">price</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(deprecated) Price.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="price">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">bulk_item</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Bulk item: 1 or 0.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="bulk_item">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">picture_option</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Picture option: 1 or 0.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="picture_option">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">street</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Street.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="street">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">number</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Number.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="number">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">box</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Box.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="box">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">postalcode</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Postal code.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="postalcode">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">city</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) City.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="city">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">longitude</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Longitude.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="longitude">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">latitude</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Latitude.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="latitude">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">add_infos</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Infos added.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="add_infos">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">pickup_date</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Pickup date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="pickup_date">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">pickup_option</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Pickup option: delayed, direct...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="pickup_option">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">storage_date</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Storage date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="storage_date">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">ending_date</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Ending date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="ending_date">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">billing_date</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Billing date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="billing_date">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">billing_status</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Billing status: pending, unpaid...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="billing_status">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">billing_ref</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Billing_ref.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="billing_ref">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">box_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Box id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="box_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">storage_country</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Storing country.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="storage_country">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">storage_warehouse</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Storing warehouse.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="storage_warehouse">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">storage_floor</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Storing floor.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="storage_floor">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">storage_row</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Storing row.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="storage_row">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">storage_rack</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Storing rack.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="storage_rack">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">storage_rack_floor</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Storing rack flood.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="storage_rack_floor">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">storage_pallet</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Storing pallet.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="storage_pallet">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">intern_note</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Intern note.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="intern_note">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">price_estimation</div>
                                <div class="parameter-type">double</div>
                                <div class="parameter-desc">(optionnal) Price estimation.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="price_estimation">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">volume_m3</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Volume in cubic meters.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="volume_m3">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiItems_save"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>save</h3></li>
                            <li>api/v2/items</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Add an item.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/items" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">user_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Customer.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="user_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">pickup_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Pickup.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="pickup_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">ref</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Reference.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="ref">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">type</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Type: bike, box, suitcase, fridge, other...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="type">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">status</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Status: with_me, in_storage, in_transit.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="status">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">status_admin</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Status used for app and admin</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="status_admin">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="name">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">description</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Description.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="description">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">file$photo</div>
                                <div class="parameter-type">\file</div>
                                <div class="parameter-desc">(optionnal) Photo.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="file$photo">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">weight</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Weight.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="weight">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">price</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Price.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="price">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">bulk_item</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Bulk item: 1 or 0.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="bulk_item">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">picture_option</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Picture option: 1 or 0.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="picture_option">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">street</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Street.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="street">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">number</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Number.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="number">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">box</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Box.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="box">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">postalcode</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Postal code.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="postalcode">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">city</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) City.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="city">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">longitude</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Longitude.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="longitude">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">latitude</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Latitude.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="latitude">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">add_infos</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Infos added.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="add_infos">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">pickup_date</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Pickup date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="pickup_date">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">pickup_option</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Pickup option: delayed, direct...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="pickup_option">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">storage_date</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Storage date.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="storage_date">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">ending_date</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Ending date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="ending_date">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">billing_date</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Billing date.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="billing_date">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">billing_status</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Billing status: pending, unpaid...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="billing_status">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">billing_ref</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Billing_ref.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="billing_ref">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">box_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Box id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="box_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">storage_country</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Storing country.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="storage_country">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">storage_warehouse</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Storing warehouse.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="storage_warehouse">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">storage_floor</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Storing floor.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="storage_floor">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">storage_row</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Storing row.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="storage_row">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">storage_rack</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Storing rack.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="storage_rack">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">storage_rack_floor</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Storing rack flood.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="storage_rack_floor">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">storage_pallet</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Storing pallet.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="storage_pallet">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">intern_note</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Intern note.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="intern_note">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">price_estimation</div>
                                <div class="parameter-type">double</div>
                                <div class="parameter-desc">(optionnal) Price estimation.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="price_estimation">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">volume_m3</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Volume in cubic meters.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="volume_m3">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order_assurance_id</div>
                                <div class="parameter-type">integer</div>
                                <div class="parameter-desc">(optionnal) Id of the order_assurance</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_assurance_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">datetime$end_commitement_date</div>
                                <div class="parameter-type">\datetime</div>
                                <div class="parameter-desc">(optionnal) Id end of the end commitement</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="datetime$end_commitement_date">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">fragile</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) if item is fragile or not</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="fragile">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiItems_types"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>types</h3></li>
                            <li>api/v2/items/types</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get item types.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/items/types" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">locale</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Locale: en, fr, nl. Default: en.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="locale">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiItems_statuses"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>statuses</h3></li>
                            <li>api/v2/items/statuses</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get item statuses.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/items/statuses" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Id of the Item</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">url</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Url to delete</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="url">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiItems_pickupOptions"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>pickupOptions</h3></li>
                            <li>api/v2/items/pickup-options</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get item pickup options.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/items/pickup-options" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Id of the Item</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">url</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Url to delete</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="url">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiItems_removeFile"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>removeFile</h3></li>
                            <li>api/v2/items/remove-file</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Remove a file associated to an item</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/items/remove-file" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Id of the Item</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">url</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Url to delete</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="url">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiItems_delete"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>DELETE</h2></li>
                            <li><h3>delete</h3></li>
                            <li>api/v2/items</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Delete an item (soft delete)</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/items" type="DELETE">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="DELETE"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiPickups"></a>
                        <h2>ApiPickups</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiPickups_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v2/pickups</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get pickups.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/pickups" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiPickups_add"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>add</h3></li>
                            <li>api/v2/pickups</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Add an pickup.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/pickups" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">user_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Customer.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="user_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">total</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Total.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="total">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">street</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Street.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="street">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">number</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Number.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="number">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">box</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Box.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="box">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">postalcode</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Postal code.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="postalcode">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">city</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) City.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="city">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">status</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Status: ordered, getback.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="status">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">add_infos</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Infos added.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="add_infos">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">history</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) History.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="history">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">pickup_date</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Pickup date from. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="pickup_date">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">file$sign_photo</div>
                                <div class="parameter-type">\file</div>
                                <div class="parameter-desc">(optionnal) Sign photo.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="file$sign_photo">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">intern_note</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Intern note.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="intern_note">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">dropoff_date_from</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Dropoff date from. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="dropoff_date_from">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">dropoff_intern_note</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Dropoff intern note.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="dropoff_intern_note">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">dropoff_date_to</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Dropoff date to. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="dropoff_date_to">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">pickup_date_to</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal)  Pickup date to. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="pickup_date_to">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">pickup_option</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal)  Pickup option.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="pickup_option">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order_booking_id</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Booking.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_booking_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">assigned_delivery_arxmin_user_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Assigned transporter.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="assigned_delivery_arxmin_user_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiPickups_save"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>save</h3></li>
                            <li>api/v2/pickups</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Save an pickup.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/pickups" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">user_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Customer.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="user_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">total</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Total.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="total">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">street</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Street.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="street">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">number</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Number.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="number">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">box</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Box.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="box">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">postalcode</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Postal code.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="postalcode">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">city</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) City.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="city">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">status</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Status: ordered, getback.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="status">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">add_infos</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Infos added.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="add_infos">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">history</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) History.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="history">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">pickup_date</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Pickup date from. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="pickup_date">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">file$sign_photo</div>
                                <div class="parameter-type">\file</div>
                                <div class="parameter-desc">(optionnal) Sign photo.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="file$sign_photo">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">intern_note</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Intern note.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="intern_note">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">dropoff_date_from</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Dropoff date from. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="dropoff_date_from">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">dropoff_intern_note</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Dropoff intern note.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="dropoff_intern_note">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">dropoff_date_to</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Dropoff date to. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="dropoff_date_to">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">pickup_date_to</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal)  Pickup date to. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="pickup_date_to">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">pickup_option</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal)  Pickup option.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="pickup_option">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order_booking_id</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Booking.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_booking_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">assigned_delivery_arxmin_user_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Assigned transporter.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="assigned_delivery_arxmin_user_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiTodos"></a>
                        <h2>ApiTodos</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiTodos_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v2/todos</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get todos.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/todos" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiTodos_add"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>add</h3></li>
                            <li>api/v2/todos</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Add a todo.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/todos" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">title</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Title.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="title">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">assigned_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Assigned.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="assigned_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">type</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Type.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="type">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">completed</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Completed:  1 or 0. Default : 0.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="completed">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiTodos_save"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>save</h3></li>
                            <li>api/v2/todos</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Save a todo.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/todos" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">title</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Title.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="title">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">assigned_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Assigned.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="assigned_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">type</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Type.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="type">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">completed</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Completed:  1 or 0. Default : 0.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="completed">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiUsers"></a>
                        <h2>ApiUsers</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiUsers_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v2/users</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get users.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/users" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiUsers_add"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>add</h3></li>
                            <li>api/v2/users</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Add a user.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/users" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">email</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Email, unique.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="email">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="name">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first_name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) First name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first_name">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">last_name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Last name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="last_name">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">postalcode</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Postal code.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="postalcode">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">add_infos</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Infos added.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="add_infos">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">city</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) City.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="city">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">box</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Box.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="box">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">number</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Number.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="number">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">street</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Street.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="street">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">latitude</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Latitude.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="latitude">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">longitude</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Longitude.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="longitude">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">phone</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Phone.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="phone">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">godfather_id</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) User godfather.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="godfather_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">lang</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Lang.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="lang">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">business</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Business: 1 or 0.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="business">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">password</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Password.</div>
                                <div class="parameter-value">
                                    <input type="password" class="parameter-value-text" name="password">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">active</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Active: 1 or 0.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="active">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">status</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Status: active or empty.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="status">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">avg_card</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Avantage card.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="avg_card">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">last_order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Last order date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="last_order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">country</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Country.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="country">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">customer_type</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Customer type : private or professionnal. Default value is private.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="customer_type">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">id_card_file_recto</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) ID Card file recto.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id_card_file_recto">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">id_card_file_verso</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) ID Card file verso.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id_card_file_verso">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">oauth_id</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Facebook id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="oauth_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">deleted_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Deleted date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="deleted_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiUsers_save"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>save</h3></li>
                            <li>api/v2/users</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Save a user.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/users" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">email</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Email, unique.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="email">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="name">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first_name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) First name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first_name">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">last_name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Last name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="last_name">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">postalcode</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Postal code.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="postalcode">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">add_infos</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Infos added.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="add_infos">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">city</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) City.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="city">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">box</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Box.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="box">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">number</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Number.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="number">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">street</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Street.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="street">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">latitude</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Latitude.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="latitude">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">longitude</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Longitude.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="longitude">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">phone</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Phone.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="phone">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">godfather_id</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) User godfather.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="godfather_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">lang</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Lang.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="lang">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">business</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Business: 1 or 0.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="business">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">password</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Password.</div>
                                <div class="parameter-value">
                                    <input type="password" class="parameter-value-text" name="password">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">active</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Active: 1 or 0.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="active">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">status</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Status: active or empty.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="status">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">avg_card</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Avantage card.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="avg_card">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">country</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Country.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="country">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">customer_type</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Customer type : private or professionnal. Default value is private.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="customer_type">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">file$id_card_file_recto</div>
                                <div class="parameter-type">\file</div>
                                <div class="parameter-desc">(optionnal) ID Card file recto.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="file$id_card_file_recto">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">file$id_card_file_verso</div>
                                <div class="parameter-type">\file</div>
                                <div class="parameter-desc">(optionnal) ID Card file verso.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="file$id_card_file_verso">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">oauth_id</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Facebook id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="oauth_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">last_order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Last order date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="last_order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">deleted_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Deleted date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="deleted_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order_plan_region_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">Order Plan Region id</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_plan_region_id">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiUsers_cities"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>cities</h3></li>
                            <li>api/v2/users/cities</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get cities.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/users/cities" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">Request$request</div>
                                <div class="parameter-type">\Request</div>
                                <div class="parameter-desc"></div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="Request$request">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiUsers_login"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>login</h3></li>
                            <li>api/v2/users/login</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Login.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/users/login" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">email</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Email.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="email">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">password</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Password.</div>
                                <div class="parameter-value">
                                    <input type="password" class="parameter-value-text" name="password">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiUsers_delete"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>DELETE</h2></li>
                            <li><h3>delete</h3></li>
                            <li>api/v2/users</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Delete an user</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/users" type="DELETE">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="DELETE"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiOrderAnswers"></a>
                        <h2>ApiOrderAnswers</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiOrderAnswers_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v2/order/answers</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get anwsers.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/answers" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiOrderAnswers_add"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>add</h3></li>
                            <li>api/v2/order/answers</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Add a anwser.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/answers" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">order_question_parent_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Question parent.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_question_parent_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order_question_target_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Question target.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_question_target_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">slug</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Slug, unique.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="slug">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">value_</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(required) Yes or no for boolean question.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="value_">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">value_number_from</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Range for number question.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="value_number_from">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">value_number_to</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Range for number question.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="value_number_to">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">appointment</div>
                                <div class="parameter-type">double</div>
                                <div class="parameter-desc">(required) Appointment.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="appointment">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">appointment_by_number</div>
                                <div class="parameter-type">double</div>
                                <div class="parameter-desc">(required) Appointment depending of the anwser for number question.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="appointment_by_number">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiOrderAnswers_save"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>save</h3></li>
                            <li>api/v2/order/answers</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Save a anwser.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/answers" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order_question_parent_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Question parent.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_question_parent_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order_question_target_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Question target.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_question_target_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">slug</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Slug, unique.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="slug">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">value_</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Yes or no for boolean question.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="value_">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">value_number_from</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Range for number question.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="value_number_from">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">value_number_to</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Range for number question.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="value_number_to">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">appointment</div>
                                <div class="parameter-type">double</div>
                                <div class="parameter-desc">(optionnal) Appointment.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="appointment">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">appointment_by_number</div>
                                <div class="parameter-type">double</div>
                                <div class="parameter-desc">(optionnal) Appointment depending of the anwser for number question.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="appointment_by_number">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiAreas"></a>
                        <h2>ApiAreas</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiAreas_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v2/areas</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get areas</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/areas" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">slug</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">unique slug of the areas (required)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="slug">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">name[]</div>
                                <div class="parameter-type">array</div>
                                <div class="parameter-desc">Name associated to the areas (format ["en" => ["name"=>"Brussels"],"fr" => ["name" => "Bruxelles"]] (required)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="name[]">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">zip_code</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">Zipcode of the area (required)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="zip_code">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">region_id</div>
                                <div class="parameter-type">integer</div>
                                <div class="parameter-desc">Region ID where the area belong (optionnal)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="region_id">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiAreas_add"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>add</h3></li>
                            <li>api/v2/areas</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Add a area.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/areas" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">slug</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">unique slug of the areas (required)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="slug">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">name[]</div>
                                <div class="parameter-type">array</div>
                                <div class="parameter-desc">Name associated to the areas (format ["en" => ["name"=>"Brussels"],"fr" => ["name" => "Bruxelles"]] (required)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="name[]">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">zip_code</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">Zipcode of the area (required)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="zip_code">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">region_id</div>
                                <div class="parameter-type">integer</div>
                                <div class="parameter-desc">Region ID where the area belong (optionnal)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="region_id">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiAreas_save"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>save</h3></li>
                            <li>api/v2/areas</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Save a area.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/areas" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">integer</div>
                                <div class="parameter-desc">(required)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">slug</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">unique slug of the areas (required)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="slug">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">name[]</div>
                                <div class="parameter-type">array</div>
                                <div class="parameter-desc">Name associated to the areas (format ["en" => ["name"=>"Brussels"],"fr" => ["name" => "Bruxelles"]] (required)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="name[]">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">zip_code</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">Zipcode of the area (required)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="zip_code">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">region_id</div>
                                <div class="parameter-type">integer</div>
                                <div class="parameter-desc">Region ID where the area belong (optionnal)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="region_id">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiAreas_delete"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>DELETE</h2></li>
                            <li><h3>delete</h3></li>
                            <li>api/v2/areas</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Delete area</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/areas" type="DELETE">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">id of the area to delete</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="DELETE"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiOrderAssurances"></a>
                        <h2>ApiOrderAssurances</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiOrderAssurances_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v2/order/assurances</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get assurances.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/assurances" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiOrderAssurances_add"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>add</h3></li>
                            <li>api/v2/order/assurances</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Add a assurance.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/assurances" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">slug</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Slug, unique.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="slug">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">price_per_month</div>
                                <div class="parameter-type">double</div>
                                <div class="parameter-desc">(required) Price per month.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="price_per_month">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">on_demand</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(required) On demand: 1 or 0.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="on_demand">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiOrderAssurances_save"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>save</h3></li>
                            <li>api/v2/order/assurances</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Save a assurance.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/assurances" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">slug</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Slug, unique.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="slug">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">price_per_month</div>
                                <div class="parameter-type">double</div>
                                <div class="parameter-desc">(optionnal) Price per month.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="price_per_month">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">on_demand</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) On demand: 1 or 0.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="on_demand">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiOrderBookings"></a>
                        <h2>ApiOrderBookings</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiOrderBookings_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v2/order/bookings</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get bookings.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/bookings" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiOrderBookings_add"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>add</h3></li>
                            <li>api/v2/order/bookings</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Add a booking.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/bookings" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">price_per_month</div>
                                <div class="parameter-type">double</div>
                                <div class="parameter-desc">(required) Price per month. Plan - commitment discount + assurance.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="price_per_month">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">appointment</div>
                                <div class="parameter-type">double</div>
                                <div class="parameter-desc">(required) Appointment. Services + delivery costs.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="appointment">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">dropoff_date</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Dropoff date. Format: YYYY-MM-DD 00:00:00.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="dropoff_date">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">dropoff_time</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Dropoff time.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="dropoff_time">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">pickup_date</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Pickup date. Format: YYYY-MM-DD 00:00:00.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="pickup_date">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">pickup_time</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required)  Pickup time.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="pickup_time">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">address_full</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Full address.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="address_full">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">address_route</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Address route.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="address_route">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">address_street_number</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Address street number.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="address_street_number">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">address_city</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Address city.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="address_city">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">address_postal_code</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Address postal code.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="address_postal_code">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">address_country</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Address country.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="address_country">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">address_box</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Address box.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="address_box">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">wait_fill_boxes</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(required) Wait fill boxed: 1 or 0.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="wait_fill_boxes">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">company_address_name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Company name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="company_address_name">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">company_address_vat_number</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Company vat number.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="company_address_vat_number">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">company_address_full</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Company full address.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="company_address_full">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">company_address_route</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Company address route.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="company_address_route">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">company_address_street_number</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Company address street number.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="company_address_street_number">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">company_address_locality</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Company address city.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="company_address_locality">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">company_address_postal_code</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Company address postal code.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="company_address_postal_code">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">company_address_country</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Company address country.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="company_address_country">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">company_address_box</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Company address box.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="company_address_box">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">how_did_you_know_about_us</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) How did you know about us.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="how_did_you_know_about_us">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">comments</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Comments.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="comments">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">user_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) User, customer.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="user_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order_plan_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Plan.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_plan_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order_storing_duration_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Storing duration.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_storing_duration_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order_assurance_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Assurance.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_assurance_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order_booking_status_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Status.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_booking_status_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiOrderBookings_save"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>save</h3></li>
                            <li>api/v2/order/bookings</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Save a booking.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/bookings" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">price_per_month</div>
                                <div class="parameter-type">double</div>
                                <div class="parameter-desc">(optionnal) Price per month. Plan - commitment discount + assurance.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="price_per_month">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">appointment</div>
                                <div class="parameter-type">double</div>
                                <div class="parameter-desc">(optionnal) Appointment. Services + delivery costs.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="appointment">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">dropoff_date</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Dropoff date. Format: YYYY-MM-DD 00:00:00.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="dropoff_date">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">dropoff_time</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Dropoff time.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="dropoff_time">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">pickup_date</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Pickup date. Format: YYYY-MM-DD 00:00:00.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="pickup_date">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">pickup_time</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal)  Pickup time.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="pickup_time">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">address_full</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Full address.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="address_full">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">address_route</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Address route.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="address_route">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">address_street_number</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Address street number.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="address_street_number">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">address_locality</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Address city.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="address_locality">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">address_postal_code</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Address postal code.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="address_postal_code">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">address_country</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Address country.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="address_country">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">address_box</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Address box.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="address_box">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">wait_fill_boxes</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Wait fill boxed: 1 or 0.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="wait_fill_boxes">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">company_address_name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Company name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="company_address_name">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">company_address_vat_number</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Company vat number.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="company_address_vat_number">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">company_address_full</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Company full address.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="company_address_full">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">company_address_route</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Company address route.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="company_address_route">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">company_address_street_number</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Company address street number.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="company_address_street_number">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">company_address_locality</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Company address city.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="company_address_locality">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">company_address_postal_code</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Company address postal code.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="company_address_postal_code">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">company_address_country</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Company address country.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="company_address_country">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">company_address_box</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Company address box.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="company_address_box">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">how_did_you_know_about_us</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) How did you know about us.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="how_did_you_know_about_us">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">comments</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Comments.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="comments">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">user_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) User, customer.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="user_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order_plan_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Plan.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_plan_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order_storing_duration_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Storing duration.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_storing_duration_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order_assurance_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Assurance.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_assurance_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order_booking_status_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Status.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_booking_status_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiOrderBookings_delete"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>DELETE</h2></li>
                            <li><h3>delete</h3></li>
                            <li>api/v2/order/bookings</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Delete an order booking</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/bookings" type="DELETE">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="DELETE"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiOrderBookingStatuses"></a>
                        <h2>ApiOrderBookingStatuses</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiOrderBookingStatuses_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v2/order/bookings/statuses</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get booking statuses.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/bookings/statuses" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiOrderBookingStatuses_add"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>add</h3></li>
                            <li>api/v2/order/bookings/statuses</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Add a booking status.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/bookings/statuses" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">slug</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Slug, unique.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="slug">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiOrderBookingStatuses_save"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>save</h3></li>
                            <li>api/v2/order/bookings/statuses</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Save a booking status.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/bookings/statuses" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">slug</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Slug, unique.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="slug">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiOrderCalculatorCategories"></a>
                        <h2>ApiOrderCalculatorCategories</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiOrderCalculatorCategories_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v2/order/calculator/categories</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get calculator categories.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/calculator/categories" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiOrderCalculatorCategories_add"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>add</h3></li>
                            <li>api/v2/order/calculator/categories</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Add a calculator category.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/calculator/categories" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">slug</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Slug, unique.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="slug">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiOrderCalculatorCategories_save"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>save</h3></li>
                            <li>api/v2/order/calculator/categories</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Save a calculator category.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/calculator/categories" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">slug</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Slug, unique.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="slug">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiOrderCalculatorItems"></a>
                        <h2>ApiOrderCalculatorItems</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiOrderCalculatorItems_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v2/order/calculator/items</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get calculator items.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/calculator/items" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiOrderCalculatorItems_add"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>add</h3></li>
                            <li>api/v2/order/calculator/items</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Add a calculator item.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/calculator/items" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">order_calculator_category_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Category.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_calculator_category_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">slug</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Slug, unique.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="slug">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">area_m2</div>
                                <div class="parameter-type">double</div>
                                <div class="parameter-desc">(required) Area m2.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="area_m2">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">volume_m3</div>
                                <div class="parameter-type">double</div>
                                <div class="parameter-desc">(required) Volume m3.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="volume_m3">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">price</div>
                                <div class="parameter-type">double</div>
                                <div class="parameter-desc">(optionnal) Price.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="price">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiOrderCalculatorItems_save"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>save</h3></li>
                            <li>api/v2/order/calculator/items</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Save a calculator item.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/calculator/items" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order_calculator_category_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Category.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_calculator_category_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">slug</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Slug, unique.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="slug">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">area_m2</div>
                                <div class="parameter-type">double</div>
                                <div class="parameter-desc">(required) Area m2.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="area_m2">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">volume_m3</div>
                                <div class="parameter-type">double</div>
                                <div class="parameter-desc">(required) Volume m3.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="volume_m3">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">price</div>
                                <div class="parameter-type">double</div>
                                <div class="parameter-desc">(optionnal) Price.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="price">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiOrderPlanAssets"></a>
                        <h2>ApiOrderPlanAssets</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiOrderPlanAssets_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v2/order/plans/assets</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get plan assets.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/plans/assets" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiOrderPlanAssets_add"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>add</h3></li>
                            <li>api/v2/order/plans/assets</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Add a plan asset.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/plans/assets" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">slug</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Slug, unique.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="slug">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiOrderPlanAssets_save"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>save</h3></li>
                            <li>api/v2/order/plans/assets</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Save a plan asset.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/plans/assets" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">slug</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Slug, unique.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="slug">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiOrderPlanCategories"></a>
                        <h2>ApiOrderPlanCategories</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiOrderPlanCategories_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v2/order/plans/categories</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get plan categories.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/plans/categories" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiOrderPlanCategories_add"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>add</h3></li>
                            <li>api/v2/order/plans/categories</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Add a plan category.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/plans/categories" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">slug</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Slug, unique.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="slug">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiOrderPlanCategories_save"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>save</h3></li>
                            <li>api/v2/order/plans/categories</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Save a plan category.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/plans/categories" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">slug</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Slug, unique.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="slug">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiOrderPlans"></a>
                        <h2>ApiOrderPlans</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiOrderPlans_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v2/order/plans</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get plans.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/plans" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiOrderPlans_add"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>add</h3></li>
                            <li>api/v2/order/plans</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Add a plan.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/plans" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">order_plan_category_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Category.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_plan_category_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">slug</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Slug, unique.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="slug">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">volume_m3</div>
                                <div class="parameter-type">double</div>
                                <div class="parameter-desc">(required) Volume m3.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="volume_m3">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">price_per_month</div>
                                <div class="parameter-type">double</div>
                                <div class="parameter-desc">(required) Price per month in euros.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="price_per_month">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order_plan_assets</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) array of order_plan_assets with ids.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_plan_assets">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiOrderPlans_save"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>save</h3></li>
                            <li>api/v2/order/plans</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Save a plan.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/plans" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order_plan_category_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Category.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_plan_category_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">slug</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Slug, unique.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="slug">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">volume_m3</div>
                                <div class="parameter-type">double</div>
                                <div class="parameter-desc">(optionnal) Volume m3.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="volume_m3">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">price_per_month</div>
                                <div class="parameter-type">double</div>
                                <div class="parameter-desc">(optionnal) Price per month in euros.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="price_per_month">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiOrderPlans_delete"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>DELETE</h2></li>
                            <li><h3>delete</h3></li>
                            <li>api/v2/order/plans</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Delete Plan</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/plans" type="DELETE">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">id of the Plan to delete</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="DELETE"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiOrderPlanRegion"></a>
                        <h2>ApiOrderPlanRegion</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiOrderPlanRegion_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v2/order/plans/regions</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get Regions</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/plans/regions" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">user_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) get plans by the user region</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="user_id">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiOrderPlanRegion_add"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>add</h3></li>
                            <li>api/v2/order/plans/regions</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Add a Region.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/plans/regions" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">integer</div>
                                <div class="parameter-desc"></div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc"></div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="name">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiOrderPlanRegion_save"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>save</h3></li>
                            <li>api/v2/order/plans/regions</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Save a Region.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/plans/regions" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">integer</div>
                                <div class="parameter-desc"></div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc"></div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="name">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiOrderPlanRegion_delete"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>DELETE</h2></li>
                            <li><h3>delete</h3></li>
                            <li>api/v2/order/plans/regions</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Delete Region</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/plans/regions" type="DELETE">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">id of the Region to delete</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="DELETE"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiOrderQuestions"></a>
                        <h2>ApiOrderQuestions</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiOrderQuestions_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v2/order/questions</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get questions.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/questions" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiOrderQuestions_add"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>add</h3></li>
                            <li>api/v2/order/questions</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Add a question.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/questions" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">slug</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Slug, unique.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="slug">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">type</div>
                                <div class="parameter-type">double</div>
                                <div class="parameter-desc">(required) Type: boolean or number.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="type">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiOrderQuestions_save"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>save</h3></li>
                            <li>api/v2/order/questions</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Save a question.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/questions" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">slug</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Slug, unique.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="slug">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">type</div>
                                <div class="parameter-type">double</div>
                                <div class="parameter-desc">(optionnal) Type: boolean or number.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="type">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiRegions"></a>
                        <h2>ApiRegions</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiRegions_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v2/regions</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get Regions</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/regions" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">integer</div>
                                <div class="parameter-desc"></div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc"></div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="name">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiRegions_add"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>add</h3></li>
                            <li>api/v2/regions</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Add a Region.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/regions" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">integer</div>
                                <div class="parameter-desc"></div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc"></div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="name">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiRegions_save"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>save</h3></li>
                            <li>api/v2/regions</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Save a Region.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/regions" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">integer</div>
                                <div class="parameter-desc"></div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc"></div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="name">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiRegions_delete"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>DELETE</h2></li>
                            <li><h3>delete</h3></li>
                            <li>api/v2/regions</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Delete Region</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/regions" type="DELETE">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">id of the Region to delete</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="DELETE"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiOrderStoringDurations"></a>
                        <h2>ApiOrderStoringDurations</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiOrderStoringDurations_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v2/order/storing-durations</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get storing durations.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/storing-durations" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiOrderStoringDurations_add"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>add</h3></li>
                            <li>api/v2/order/storing-durations</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Add a storing duration.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/storing-durations" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">slug</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Slug, unique.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="slug">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">discount_percentage</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Discount percentage.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="discount_percentage">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiOrderStoringDurations_save"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>save</h3></li>
                            <li>api/v2/order/storing-durations</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Save a storing duration.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/order/storing-durations" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">slug</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Slug, unique.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="slug">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">discount_percentage</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Discount percentage.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="discount_percentage">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiWarehouses"></a>
                        <h2>ApiWarehouses</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiWarehouses_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v2/warehouses</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get users.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/warehouses" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiNotifications"></a>
                        <h2>ApiNotifications</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiNotifications_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v2/notifications</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get notification</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/notifications" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiNotifications_add"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>add</h3></li>
                            <li>api/v2/notifications</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Add a notification</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/notifications" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">slug</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) slug</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="slug">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">detail_json</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) details in json</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="detail_json">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiNotifications_save"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>save</h3></li>
                            <li>api/v2/notifications</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Update a notification</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/notifications" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">slug</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnel) slug</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="slug">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">detail_json</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnel) details in json</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="detail_json">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiArxminUsers"></a>
                        <h2>ApiArxminUsers</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiArxminUsers_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v2/arxmin/users</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get transporters.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/arxmin/users" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiArxminUsers_add"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>add</h3></li>
                            <li>api/v2/arxmin/users</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Add a transporter.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/arxmin/users" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">first_name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) First Name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first_name">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">last_name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Last Name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="last_name">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">email</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Email, unique.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="email">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">password</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Password.</div>
                                <div class="parameter-value">
                                    <input type="password" class="parameter-value-text" name="password">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiArxminUsers_save"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>save</h3></li>
                            <li>api/v2/arxmin/users</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Save a transporter.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/arxmin/users" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="name">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">email</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Email, unique.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="email">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">password</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Password.</div>
                                <div class="parameter-value">
                                    <input type="password" class="parameter-value-text" name="password">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiArxminUsers_delete"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>DELETE</h2></li>
                            <li><h3>delete</h3></li>
                            <li>api/v2/arxmin/users</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Delete arxmin user (soft delete)</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/arxmin/users" type="DELETE">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="DELETE"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiArxminUsers_login"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>login</h3></li>
                            <li>api/v2/arxmin/login</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Login.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/arxmin/login" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">email</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Email.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="email">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">password</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Password.</div>
                                <div class="parameter-value">
                                    <input type="password" class="parameter-value-text" name="password">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiArxminUsers_permissions"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>permissions</h3></li>
                            <li>api/v2/arxmin/permissions</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Permissions</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/arxmin/permissions" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">email</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Email</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="email">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiArxminUsers_reset"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>reset</h3></li>
                            <li>api/v2/arxmin/reset</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Reset arxmin user</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v2/arxmin/reset" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">email</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Email</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="email">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>


                    </div>
                </div>
            </div>
        </div>


    </body>
</html>
