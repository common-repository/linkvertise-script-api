jQuery(function () {
  jQuery('#radios input[type=radio]').change(function () {
    if (jQuery(this).val() === '1') {
      jQuery('#linkvertiseScriptApiExtLinkListSection').html(
        '<p><b>' + translated_strings.blacklist_description_title + '</p></b>' +
        '<p>' + translated_strings.blacklist_description + '</p>'
      );
    }
    else {
      jQuery('#linkvertiseScriptApiExtLinkListSection').html(
        '<p><b>' + translated_strings.whitelist_description_title + '</p></b>' +
        '<p>' + translated_strings.whitelist_description + '</p>'
      );
    }
  })
});