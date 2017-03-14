jQuery(function () {
    var $ = jQuery;

    try {
        var accounts          = JSON.parse($('#view-selector-data').val()),
            currentAccountId  = $('#currentAccountId').val(),
            currentPropertyId = $('#currentPropertyId').val(),
            currentViewId     = $('#currentViewId').val(),
            currentAccount    = findItemById(currentAccountId, accounts) || accounts[0],
            currentProperty   = findItemById(currentPropertyId, currentAccount['properties']) || accounts[0]['properties'][0],
            currentView       = findItemById(currentViewId, currentProperty['views']) || accounts[0]['properties'][0]['views'][0];
    } catch (e) {
        return;
    }


    new Vue({
        el: '#ga-view-selector',
        data: {
            accounts: accounts,
            currentAccount: currentAccount,
            currentProperty: currentProperty,
            currentView: currentView,
            currentAccountId: currentAccountId,
            currentPropertyId: currentPropertyId,
            currentViewId: currentViewId,
        },
        methods: {
            changeAccount: function () {
                var accountId = this.$refs.account.value;

                this.currentAccount = findItemById(accountId, this.accounts);
                this.currentProperty = this.currentAccount.properties[0];
                this.currentPropertyId = this.currentProperty.id;
                this.currentViewId = this.currentProperty['views'][0].id;

            },

            changeProperty: function () {
                var propertyId = this.$refs.property.value;

                this.currentProperty = findItemById(propertyId, this.currentAccount.properties);
                this.currentViewId = this.currentProperty['views'][0].id;

            },
        }
    });


    /*------------------------------------*\
     # sync order by when metrics changes
     \*------------------------------------*/

    var $orderBys         = $('#js-ga-order-bys'),
        $metrics          = $('#js-ga-metrics'),
        orderBysSelectize = $orderBys[0].selectize;


    function addMinusSign(arr) {
        return _.flatten(
            arr.map(function (value) {
                return ['-' + value, value];
            })
        );
    }

    function filterOutMinusSign(arr) {
        return arr.filter(function (value) {
            return !value.match(/^-/);
        });
    }


    $metrics.on('change', function () {
        var previousValues = $orderBys.val() || [],
            newValues      = addMinusSign($metrics.val() || []),
            remainedValues = _.intersection(previousValues, newValues),
            addedValues    = _.difference(newValues, previousValues),
            allValues      = addMinusSign(filterOutMinusSign(addedValues.concat(remainedValues)).sort());

        //var allRemainedValues
        orderBysSelectize.clearOptions();

        allValues.forEach(function (value) {
            // add options
            orderBysSelectize.addOption({text: value, value: value});
        });

        remainedValues.forEach(function (value) {
            // add selected values
            orderBysSelectize.addItem(value);
        });
    }).trigger('change');


    /*------------------------------------*\
     # post types control
     \*------------------------------------*/
    var $postTypes         = $('#js-gapp-post-types'),
        postTypesSelectize = $postTypes[0].selectize;

    postTypesSelectize.on('item_add', function (value, $item) {
        if (value == 'any') {
            _.without(this.getValue(), 'any').forEach(function (value) {
                postTypesSelectize.removeItem(value, true);
            });
        } else {
            postTypesSelectize.removeItem('any', true);
        }

        postTypesSelectize.refreshOptions();
    });


    function findItemById(id, items) {
        return items.find(function (item) {
            return item.id == id;
        });
    }
});