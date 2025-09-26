jQuery(document).ready(function ($) {
  // Disable a couple of WCGWP settings checkboxes
  $("#wcgwp_multiples, #wcgwp_all_products").attr("disabled", true);

  $("#wcgwp-wrap-category-link").on("click", function () {
    $("#wcgwp_category_id").focus();
    $([document.documentElement, document.body]).animate(
      {
        scrollTop: $("#wcgwp_category_id").offset().top - 125,
      },
      500
    );
  });

  $("#wcgwp_note_fee")
    .on("change", function () {
      if ("yes" === $(this).val()) {
        $(".wcgwp-note-fee-amount").closest("tr").show();
      } else {
        $(".wcgwp-note-fee-amount").closest("tr").hide();
      }
    })
    .trigger("change");

  $("#wcgwp_cart_display")
    .on("change", function () {
      if ("checkbox" === $(this).val()) {
        $("#wcgwp_checkbox_link").closest("tr").show();
        $("#wcgwp_show_thumb, #wcgwp_link").closest("tr").hide();
      } else {
        $("#wcgwp_checkbox_link").closest("tr").hide();
        $("#wcgwp_show_thumb, #wcgwp_link").closest("tr").show();
      }
    })
    .trigger("change");

  $("#wcgwp_number")
    .on("change", function () {
      if ("yes" === $(this).val()) {
        $(".wcgwp-number-max").closest("tr").show();
      } else {
        $(".wcgwp-number-max").closest("tr").hide();
      }
    })
    .trigger("change");

  $(".wcgwp-plus").closest("tr").hide();

  jQuery(function ($) {
    $(".titledesc").each(function () {
      const $container = $(this);
      const $label = $container.find("label[for]");
      var featureId = $label.length ? $label.attr("for") : "gift-wrap";

      if (featureId == 'gift-wrap') {
        tmp = $container.siblings('td').find('label[for]');
        if (tmp) {
          featureId = $(tmp).attr('for') ? $(tmp).attr('for') : "gift-wrap";
        }
      }

      featureId = featureId.replace(/(\[.*\])+/gi, '');

      // Traverse this element and all descendants
      $container
        .find("*")
        .addBack()
        .contents()
        .filter(function () {
          return this.nodeType === 3 && this.nodeValue.includes("(PRO)");
        })
        .each(function () {
          const text = this.nodeValue;

          // Replace the whole "(PRO)" with the link
          const replaced = text.replace(/\(PRO\)/g, '<a title="This feature is available in the PRO version. Click for details." ' + 'href="#" data-feature="' + featureId + '" ' + 'class="open-upsell pro-label">PRO</a>');

          $(this).replaceWith(replaced);
        });
    });
  });

  // pro dialog
  $('a.nav-tab-pro').on('click', function (e) {
    e.preventDefault();

    open_upsell('tab');

    return false;
  });

  $('#wpwrap').on('change', 'select', function(e) {
    option_class = $('#' + $(this).attr('id') + ' :selected').attr('class');
    if(option_class == 'pro-option'){
        option_text = $('#' + $(this).attr('id') + ' :selected').text();
        $(this).val('disabled');
        $(this).trigger('change');
        open_upsell($(this).attr('id'));
        $('.show_if_' + $(this).attr('id')).hide();
    }
  });

  $('#wpwrap').on('click', '.open-upsell', function(e) {
    e.preventDefault();
    feature = $(this).data('feature');
    $(this).blur();
    open_upsell(feature);

    return false;
  });

  $('#wpwrap').on('click', '.open-pro-dialog', function (e) {
    e.preventDefault();
    $(this).blur();

    pro_feature = $(this).data('pro-feature');
    if (!pro_feature) {
      pro_feature = $(this).parent('label').attr('for');
    }
    open_upsell(pro_feature);

    return false;
  });

  $('#gift-wrap-pro-dialog').dialog({
    dialogClass: 'wp-dialog gift-wrap-pro-dialog',
    modal: true,
    resizable: false,
    width: 850,
    height: 'auto',
    show: 'fade',
    hide: 'fade',
    close: function (event, ui) {},
    open: function (event, ui) {
      $(this).siblings().find('span.ui-dialog-title').html('Login Lockdown PRO is here!');
      giftwrap_fix_dialog_close(event, ui);
    },
    autoOpen: false,
    closeOnEscape: true,
  });

  function clean_feature(feature) {
    feature = feature || 'free-plugin-unknown';
    feature = feature.toLowerCase();
    feature = feature.replace(' ', '-');

    return feature;
  }

  function open_upsell(feature) {
    feature = clean_feature(feature);

    $('#gift-wrap-pro-dialog').dialog('open');

    $('#gift-wrap-pro-table .button-buy').each(function (ind, el) {
      tmp = $(el).data('href-org');
      tmp = tmp.replace('pricing-table', feature);
      $(el).attr('href', tmp);
    });
  } // open_upsell

  if (window.localStorage.getItem('gift-wrap_upsell_shown') != 'true') {
    open_upsell('welcome');

    window.localStorage.setItem('gift-wrap_upsell_shown', 'true');
    window.localStorage.setItem('gift-wrap_upsell_shown_timestamp', new Date().getTime());
  }

  if (window.location.hash == '#open-pro-dialog') {
    open_upsell('url-hash');
    window.location.hash = '';
  }

  function giftwrap_fix_dialog_close(event, ui) {
    jQuery('.ui-widget-overlay').bind('click', function () {
      jQuery('#' + event.target.id).dialog('close');
    });
  } // giftwrap_fix_dialog_close
});
