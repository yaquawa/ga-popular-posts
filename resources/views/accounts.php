<input type="hidden" id="view-selector-data" value="<?php echo esc_attr(json_encode($data)); ?>">
<input type="hidden" id="currentAccountId" value="<?php echo esc_attr($this->options->get('ga_account')); ?>">
<input type="hidden" id="currentPropertyId" value="<?php echo esc_attr($this->options->get('ga_property')); ?>">
<input type="hidden" id="currentViewId" value="<?php echo esc_attr($this->options->get('ga_view')); ?>">
<div id="ga-view-selector">
    <table>
        <tr>
            <th><label>Account</label></th>
            <td>
                <select @change="changeAccount" v-model="currentAccountId" ref="account" name="ga_popular_posts[ga_account]" class="regular-text">
                    <option v-for="account in accounts" :value="account.id">{{ account.name }}</option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label>Property</label></th>
            <td>
                <select @change="changeProperty" v-model="currentPropertyId" ref="property" name="ga_popular_posts[ga_property]" class="regular-text">
                    <option v-for="property in currentAccount.properties" :value="property.id">{{ property.name }}</option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label>View</label></th>
            <td>
                <select v-model="currentViewId" name="ga_popular_posts[ga_view]" class="regular-text">
                    <option v-for="view in currentProperty.views" :value="view.id">{{ view.name }}</option>
                </select>
            </td>
        </tr>
    </table>
</div>