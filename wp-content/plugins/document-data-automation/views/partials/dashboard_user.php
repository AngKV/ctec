<div id="selectionDataDXO">
    <div id="alert-not-button" class="notice-warning settings-error notice" style="display: none; padding-right: 38px; position: relative;">
        <p>
            <?php _e('You cannot perform the action because the document has a workflow associated', 'document-data-automation')  ?>
        </p>
        <button id="dismissAlert" type="button" class="notice-dismiss dismiss-alert"><span class="screen-reader-text"><?php _e('Close','document-data-automation')?></span></button>
    </div>
    <div class="wrap">
        <div id="col-container">
            <div id="DXDashboard-col-right" class="DXDashboard-dxo-col-right">
                <div class="DXDashboard-col-wrap">
                    <h2><i class="fa fa-database DXDashboard-fa"> </i> <?php _e('Usage data', 'document-data-automation'); ?></h2>
                    <div class="DXDashboard-inside">
                        <div id="dataLoaderDXO">

                        </div>
                    </div>

                </div>
                <!-- /col-wrap -->

            </div>
            <!-- /col-right -->

            <div id="DXDashboard-col-left" class="DXDashboard-dxo-col-left">
                <div class="DXDashboard-col-wrap">
					<form id="filterUsages" name="filterUsages" action="" method="post">
                        <h2 class="DXDashboard-h2"><i class="fa fa-search DXDashboard-fa"> </i> <?php _e('Search Data', 'document-data-automation'); ?>
                        </h2>
                        <div class="DXDashboard-inside">
                        </div>
                        <p><i class="fa fa-tag DXDashboard-fa"> </i> <strong><?php _e('Identifier', 'document-data-automation'); ?>
                                :</strong> <input class="regular-text filterData" type="text" id="filterIdentifier"
                                                  name="filterIdentifier"
                                                  value="<?php echo $filterIdentifier ?>"
                                                  placeholder="<?php _e('Identifier', 'document-data-automation'); ?>"
                                                  class="DXDashboard-input"/></p>
                        <p><i class="fa fa-tag"> </i> <strong><?php _e('Reference', 'document-data-automation'); ?>
                                :</strong> <input class="regular-text filterData" type="text" id="filterReference"
                                                  name="filterReference"
                                                  value="<?php echo $filterReference ?>"
                                                  placeholder="<?php _e('Reference', 'document-data-automation'); ?>"
                                                  class="DXDashboard-input"/></p>
                        <p><input class="regular-text filterData DXDashboard-filter" type="hidden" id="filterDomain" value="<?php echo $userLogin ?>"></p>
                        <p>
                            <i class="fa fa-clock-o DXDashboard-fa"> </i>
                            <strong><?php _e('Time period', 'document-data-automation'); ?>:</strong>
                            <select class="filterData  DXDashboard-filter" id="filterPeriod" name="filterPeriod">
                                <option value=""></option>
                                <option value="today" <?php if ($filterPeriod == 'today') { ?> selected <?php } ?>><?php _e('Today', 'document-data-automation'); ?></option>
                                <option value="1week" <?php if ($filterPeriod == '1week') { ?> selected <?php } ?>><?php _e('Last week', 'document-data-automation'); ?></option>
                                <option value="1month" <?php if ($filterPeriod == '1month') { ?> selected <?php } ?>><?php _e('Last month', 'document-data-automation'); ?></option>
                                <option value="3month" <?php if ($filterPeriod == '3month') { ?> selected <?php } ?>><?php _e('Last 3 months', 'document-data-automation'); ?></option>
                                <option value="1year" <?php if ($filterPeriod == '1year') { ?> selected <?php } ?>><?php _e('Last year', 'document-data-automation'); ?></option>
                                <option value="range" <?php if ($filterPeriod == 'range') { ?> selected <?php } ?> ><?php _e('Date range', 'document-data-automation'); ?></option>
                            </select>
                        <p>
                        <div id="dateRange" <?php if ($filterPeriod != 'range') { ?> style="display: none" <?php } ?>>
                            <table>
                                <tr>
                                    <td></td>
                                    <td><strong><?php _e('Day', 'document-data-automation'); ?></strong></td>
                                    <td><strong><?php _e('Month', 'document-data-automation'); ?></strong></td>
                                    <td><strong><?php _e('Year', 'document-data-automation'); ?></strong></td>
                                </tr>
                                <tr>
                                    <td><strong><?php _e('After', 'document-data-automation'); ?>:</strong></td>
                                    <td>
                                        <select id="afterDay">
                                            <option value="01" <?php if ($dayAfter == '01') { ?> selected <?php } ?> >
                                                1
                                            </option>
                                            <option value="02" <?php if ($dayAfter == '02') { ?> selected <?php } ?>>
                                                2
                                            </option>
                                            <option value="03" <?php if ($dayAfter == '03') { ?> selected <?php } ?>>
                                                3
                                            </option>
                                            <option value="04" <?php if ($dayAfter == '04') { ?> selected <?php } ?>>
                                                4
                                            </option>
                                            <option value="05" <?php if ($dayAfter == '05') { ?> selected <?php } ?>>
                                                5
                                            </option>
                                            <option value="06" <?php if ($dayAfter == '06') { ?> selected <?php } ?>>
                                                6
                                            </option>
                                            <option value="07" <?php if ($dayAfter == '07') { ?> selected <?php } ?>>
                                                7
                                            </option>
                                            <option value="08" <?php if ($dayAfter == '08') { ?> selected <?php } ?>>
                                                8
                                            </option>
                                            <option value="09" <?php if ($dayAfter == '09') { ?> selected <?php } ?>>
                                                9
                                            </option>
                                            <option value="10" <?php if ($dayAfter == '10') { ?> selected <?php } ?>>
                                                10
                                            </option>
                                            <option value="11" <?php if ($dayAfter == '11') { ?> selected <?php } ?>>
                                                11
                                            </option>
                                            <option value="12" <?php if ($dayAfter == '12') { ?> selected <?php } ?>>
                                                12
                                            </option>
                                            <option value="13" <?php if ($dayAfter == '13') { ?> selected <?php } ?>>
                                                13
                                            </option>
                                            <option value="14" <?php if ($dayAfter == '14') { ?> selected <?php } ?>>
                                                14
                                            </option>
                                            <option value="15" <?php if ($dayAfter == '15') { ?> selected <?php } ?>>
                                                15
                                            </option>
                                            <option value="16" <?php if ($dayAfter == '16') { ?> selected <?php } ?>>
                                                16
                                            </option>
                                            <option value="17" <?php if ($dayAfter == '17') { ?> selected <?php } ?>>
                                                17
                                            </option>
                                            <option value="18" <?php if ($dayAfter == '18') { ?> selected <?php } ?>>
                                                18
                                            </option>
                                            <option value="19" <?php if ($dayAfter == '19') { ?> selected <?php } ?>>
                                                19
                                            </option>
                                            <option value="20" <?php if ($dayAfter == '20') { ?> selected <?php } ?>>
                                                20
                                            </option>
                                            <option value="21" <?php if ($dayAfter == '21') { ?> selected <?php } ?>>
                                                21
                                            </option>
                                            <option value="22" <?php if ($dayAfter == '22') { ?> selected <?php } ?>>
                                                22
                                            </option>
                                            <option value="23" <?php if ($dayAfter == '23') { ?> selected <?php } ?>>
                                                23
                                            </option>
                                            <option value="24" <?php if ($dayAfter == '24') { ?> selected <?php } ?>>
                                                24
                                            </option>
                                            <option value="25" <?php if ($dayAfter == '25') { ?> selected <?php } ?>>
                                                25
                                            </option>
                                            <option value="26" <?php if ($dayAfter == '26') { ?> selected <?php } ?>>
                                                26
                                            </option>
                                            <option value="27" <?php if ($dayAfter == '27') { ?> selected <?php } ?>>
                                                27
                                            </option>
                                            <option value="28" <?php if ($dayAfter == '28') { ?> selected <?php } ?>>
                                                28
                                            </option>
                                            <option value="29" <?php if ($dayAfter == '29') { ?> selected <?php } ?>>
                                                29
                                            </option>
                                            <option value="30" <?php if ($dayAfter == '30') { ?> selected <?php } ?> >
                                                30
                                            </option>
                                            <option value="31" <?php if ($dayAfter == '31') { ?> selected <?php } ?> >
                                                31
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                        <select id="afterMonth">
                                            <option value="01" <?php if ($monthAfter == '01') { ?> selected <?php } ?> ><?php _e('Jan.', 'document-data-automation'); ?></option>
                                            <option value="02" <?php if ($monthAfter == '02') { ?> selected <?php } ?>><?php _e('Feb.', 'document-data-automation'); ?></option>
                                            <option value="03" <?php if ($monthAfter == '03') { ?> selected <?php } ?>><?php _e('Mar.', 'document-data-automation'); ?></option>
                                            <option value="04" <?php if ($monthAfter == '04') { ?> selected <?php } ?>><?php _e('Apr.', 'document-data-automation'); ?></option>
                                            <option value="05" <?php if ($monthAfter == '05') { ?> selected <?php } ?>><?php _e('May', 'document-data-automation'); ?></option>
                                            <option value="06" <?php if ($monthAfter == '06') { ?> selected <?php } ?>><?php _e('Jun.', 'document-data-automation'); ?></option>
                                            <option value="07" <?php if ($monthAfter == '07') { ?> selected <?php } ?>><?php _e('Jul.', 'document-data-automation'); ?></option>
                                            <option value="08" <?php if ($monthAfter == '08') { ?> selected <?php } ?>><?php _e('Aug.', 'document-data-automation'); ?></option>
                                            <option value="09" <?php if ($monthAfter == '09') { ?> selected <?php } ?>><?php _e('Sep.', 'document-data-automation'); ?></option>
                                            <option value="10" <?php if ($monthAfter == '10') { ?> selected <?php } ?>><?php _e('Oct.', 'document-data-automation'); ?></option>
                                            <option value="11" <?php if ($monthAfter == '11') { ?> selected <?php } ?>><?php _e('Nov.', 'document-data-automation'); ?></option>
                                            <option value="12" <?php if ($monthAfter == '12') { ?> selected <?php } ?>><?php _e('Dic.', 'document-data-automation'); ?></option>
                                        </select>
                                    </td>
                                    <td>
                                        <select id="afterYear">
                                            <option value="2018" <?php if ($yearAfter == '2018') { ?> selected <?php } ?> >
                                                2018
                                            </option>
                                            <option value="2019" <?php if ($yearAfter == '2019') { ?> selected <?php } ?>>
                                                2019
                                            </option>
                                            <option value="2020" <?php if ($yearAfter == '2020') { ?> selected <?php } ?>>
                                                2020
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong><?php _e('Before', 'document-data-automation'); ?>:</strong></td>
                                    <td>
                                        <select id="beforeDay">
                                            <option value="01" <?php if ($dayBefore == '01') { ?> selected <?php } ?> >
                                                1
                                            </option>
                                            <option value="02" <?php if ($dayBefore == '02') { ?> selected <?php } ?>>
                                                2
                                            </option>
                                            <option value="03" <?php if ($dayBefore == '03') { ?> selected <?php } ?>>
                                                3
                                            </option>
                                            <option value="04" <?php if ($dayBefore == '04') { ?> selected <?php } ?>>
                                                4
                                            </option>
                                            <option value="05" <?php if ($dayBefore == '05') { ?> selected <?php } ?>>
                                                5
                                            </option>
                                            <option value="06" <?php if ($dayBefore == '06') { ?> selected <?php } ?>>
                                                6
                                            </option>
                                            <option value="07" <?php if ($dayBefore == '07') { ?> selected <?php } ?>>
                                                7
                                            </option>
                                            <option value="08" <?php if ($dayBefore == '08') { ?> selected <?php } ?>>
                                                8
                                            </option>
                                            <option value="09" <?php if ($dayBefore == '09') { ?> selected <?php } ?>>
                                                9
                                            </option>
                                            <option value="10" <?php if ($dayBefore == '10') { ?> selected <?php } ?>>
                                                10
                                            </option>
                                            <option value="11" <?php if ($dayBefore == '11') { ?> selected <?php } ?>>
                                                11
                                            </option>
                                            <option value="12" <?php if ($dayBefore == '12') { ?> selected <?php } ?>>
                                                12
                                            </option>
                                            <option value="13" <?php if ($dayBefore == '13') { ?> selected <?php } ?>>
                                                13
                                            </option>
                                            <option value="14" <?php if ($dayBefore == '14') { ?> selected <?php } ?>>
                                                14
                                            </option>
                                            <option value="15" <?php if ($dayBefore == '15') { ?> selected <?php } ?>>
                                                15
                                            </option>
                                            <option value="16" <?php if ($dayBefore == '16') { ?> selected <?php } ?>>
                                                16
                                            </option>
                                            <option value="17" <?php if ($dayBefore == '17') { ?> selected <?php } ?>>
                                                17
                                            </option>
                                            <option value="18" <?php if ($dayBefore == '18') { ?> selected <?php } ?>>
                                                18
                                            </option>
                                            <option value="19" <?php if ($dayBefore == '19') { ?> selected <?php } ?>>
                                                19
                                            </option>
                                            <option value="20" <?php if ($dayBefore == '20') { ?> selected <?php } ?>>
                                                20
                                            </option>
                                            <option value="21" <?php if ($dayBefore == '21') { ?> selected <?php } ?>>
                                                21
                                            </option>
                                            <option value="22" <?php if ($dayBefore == '22') { ?> selected <?php } ?>>
                                                22
                                            </option>
                                            <option value="23" <?php if ($dayBefore == '23') { ?> selected <?php } ?>>
                                                23
                                            </option>
                                            <option value="24" <?php if ($dayBefore == '24') { ?> selected <?php } ?>>
                                                24
                                            </option>
                                            <option value="25" <?php if ($dayBefore == '25') { ?> selected <?php } ?>>
                                                25
                                            </option>
                                            <option value="26" <?php if ($dayBefore == '26') { ?> selected <?php } ?>>
                                                26
                                            </option>
                                            <option value="27" <?php if ($dayBefore == '27') { ?> selected <?php } ?>>
                                                27
                                            </option>
                                            <option value="28" <?php if ($dayBefore == '28') { ?> selected <?php } ?>>
                                                28
                                            </option>
                                            <option value="29" <?php if ($dayBefore == '29') { ?> selected <?php } ?>>
                                                29
                                            </option>
                                            <option value="30" <?php if ($dayBefore == '30') { ?> selected <?php } ?> >
                                                30
                                            </option>
                                            <option value="31" <?php if ($dayBefore == '31') { ?> selected <?php } ?> >
                                                31
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                        <select id="beforeMonth">
                                            <option value="01" <?php if ($monthBefore == '01') { ?> selected <?php } ?> ><?php _e('Jan.', 'document-data-automation'); ?></option>
                                            <option value="02" <?php if ($monthBefore == '02') { ?> selected <?php } ?>><?php _e('Feb.', 'document-data-automation'); ?></option>
                                            <option value="03" <?php if ($monthBefore == '03') { ?> selected <?php } ?>><?php _e('Mar.', 'document-data-automation'); ?></option>
                                            <option value="04" <?php if ($monthBefore == '04') { ?> selected <?php } ?>><?php _e('Apr.', 'document-data-automation'); ?></option>
                                            <option value="05" <?php if ($monthBefore == '05') { ?> selected <?php } ?>><?php _e('May', 'document-data-automation'); ?></option>
                                            <option value="06" <?php if ($monthBefore == '06') { ?> selected <?php } ?>><?php _e('Jun.', 'document-data-automation'); ?></option>
                                            <option value="07" <?php if ($monthBefore == '07') { ?> selected <?php } ?>><?php _e('Jul.', 'document-data-automation'); ?></option>
                                            <option value="08" <?php if ($monthBefore == '08') { ?> selected <?php } ?>><?php _e('Aug.', 'document-data-automation'); ?></option>
                                            <option value="09" <?php if ($monthBefore == '09') { ?> selected <?php } ?>><?php _e('Sep.', 'document-data-automation'); ?></option>
                                            <option value="10" <?php if ($monthBefore == '10') { ?> selected <?php } ?>><?php _e('Oct.', 'document-data-automation'); ?></option>
                                            <option value="11" <?php if ($monthBefore == '11') { ?> selected <?php } ?>><?php _e('Nov.', 'document-data-automation'); ?></option>
                                            <option value="12" <?php if ($monthBefore == '12') { ?> selected <?php } ?>><?php _e('Dic.', 'document-data-automation'); ?></option>
                                        </select>
                                    </td>
                                    <td>
                                        <select id="beforeYear">
                                            <option value="2018" <?php if ($yearBefore == '2018') { ?> selected <?php } ?> >
                                                2018
                                            </option>
                                            <option value="2019" <?php if ($yearBefore == '2019') { ?> selected <?php } ?>>
                                                2019
                                            </option>
                                            <option value="2020" <?php if ($yearBefore == '2020') { ?> selected <?php } ?>>
                                                2020
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <p>
                            <input type="hidden" id="startDate" name="startDate">
                            <input type="hidden" id="endDate" name="endDate">

                            <button id="dxo_search_data DXDashboard-dxo_search_data" class="button-primary" onclick="return false"><i
                                        class="fa fa-filter"> </i> <?php _e('Filter data', 'document-data-automation'); ?>
                            </button>
                        </p>
                    </form>
				</div>
                <!-- /col-wrap -->
            </div>
            <!-- /col-left -->
        </div>
        <!-- /col-container -->
    </div> <!-- .wrap -->
</div>
<div style="clear: both">&nbsp;</div>
<div id="box4iframe" style="display: none;">
    <iframe id="downloadIframe" style="height: 1px; width: 1px; scrolling:no; overflow: hidden; border: none" >

    </iframe>
</div>