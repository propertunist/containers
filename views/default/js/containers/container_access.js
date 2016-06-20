/**
 * Retrieve privacy/access levels through ajax
 *
 * @package containers
 */


define(function(require) {
	var $ = require('jquery');
	var elgg = require('elgg');
        
        // call the access level check action in elgg for a specific container GUID
        var getAccessArray = function(containerGUID, access_id, GUID, elementID){
            elgg.action('containers/get_access', {
                data: 
                {
                    containerGUID: containerGUID,
                    access_id: access_id,
                    GUID: GUID,
                    elementID: elementID
                },
                success: function (json) {
                    output_access = $(json.output).children('access:first').html();
                    $('.elgg-main .elgg-form .elgg-text-help').remove();
                    $('.elgg-main .elgg-form .elgg-input-access').replaceWith(output_access);
                },
                error: function()
                {
                    elgg.register_error(elgg.echo('container:accessError'));        
                    error_log(elgg.echo('container:accessError') + ' ' + containerGUID);
                }
            });
            return;
        };
        
        // when the container dropdown is changed, the available privacy options need to be re-calculated to include the relevant group access level
        $('.elgg-containers .elgg-input-dropdown').change(function(){
            if (containerGUID = $(this).val())
            {         
                access_id = $('select[name="access_id"]').val();
                GUID = $('input[name="guid"]').val();
                if (typeof GUID === 'undefined')
                    GUID = $('input[name="video_guid"]').val();
                if (typeof GUID === 'undefined')
                    GUID = $('input[name="page_guid"]').val();                
                elementID = $('select[name="access_id"]').attr('id');
                getAccessArray(containerGUID, access_id, GUID, elementID);
            }
            return;
        });
});