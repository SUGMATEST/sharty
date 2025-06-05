/*
 * upload-selection.js - makes upload fields in post form more compact
 * https://github.com/vichan-devel/Tinyboard/blob/master/js/upload-selection.js
 *
 * Released under the MIT license
 * Copyright (c) 2014 Marcin Łabanowski <marcin@6irc.net>
 *
 * Usage:
 *   $config['additional_javascript'][] = 'js/jquery.min.js';
 *   //$config['additional_javascript'][] = 'js/wpaint.js';
 *   $config['additional_javascript'][] = 'js/upload-selection.js';
 *                                                  
 */

$(function(){
  var enabled_file = true;
  var enabled_url = $("#upload_url").length > 0;
  var enabled_embed = $("#upload_embed").length > 0;
  var enabled_voice = $("#upload_voice").length > 0;
  var enabled_poll = $("#upload_poll").length > 0;
  var enabled_oekaki = typeof window.oekaki != "undefined";
  var enabled_tegaki = typeof window.tegaki_integration != "undefined";
  var enabled_jspaint = typeof window.jspaint != "undefined";

  var disable_all = function() {
    $("#upload").hide();
    $("[id^=upload_file]").hide();
    $(".file_separator").hide();
    $("#upload_url").hide();
    $("#upload_embed").hide();
    $("#upload_voice").hide();
    $("#upload_poll").hide();
    $(".add_image").hide();
    $(".dropzone-wrap").hide();

    $("#upload_poll td").empty();

    $('[id^=upload_file]').each(function(i, v) {
        $(v).val('');
    });

    if (enabled_oekaki) {
      if (window.oekaki.initialized) {
        window.oekaki.deinit();
      }
    }

    if (enabled_jspaint) {
      if (window.jspaint.initialized) {
        window.jspaint.deinit();
      }
    }
  };

  enable_file = function() {
    disable_all();
    $("#upload").show();
    $(".dropzone-wrap").show();
    $(".file_separator").show();
    $("[id^=upload_file]").show();
    $(".add_image").show();
  };

  enable_url = function() {
    disable_all();
    $("#upload").show();
    $("#upload_url").show();

    $('label[for="file_url"]').html(_("URL"));
  };

  enable_embed = function() {
    disable_all();
    $("#upload_embed").show();
  };

  enable_oekaki = function() {
    disable_all();

    window.oekaki.init();
  };

  enable_tegaki = function () {
    enable_file();
    window.tegaki_integration.show();
  }

  enable_jspaint = function() {
    disable_all();
    window.jspaint.init();
  };

  enable_voice = function () {
    enable_file();
    window.voice_integration.show();
  }

  enable_poll = function () {
    enable_file();
    window.poll_integration.show();
  }

  if (enabled_url || enabled_embed || enabled_oekaki || enabled_tegaki || enabled_jspaint) {
    $("<tr><th>"+_("Select")+"</th><td id='upload_selection'></td></tr>").insertBefore("#upload");
    var my_html = "<a href='javascript:void(0)' onclick='enable_file(); return false;'>"+_("File")+"</a>";
    if (enabled_url) {
      my_html += " / <a href='javascript:void(0)' onclick='enable_url(); return false;'>"+_("Remote")+"</a>";
    }
    if (enabled_embed) {
      my_html += " / <a href='javascript:void(0)' onclick='enable_embed(); return false;'>"+_("Embed")+"</a>";
    }
    if (enabled_oekaki) {
      my_html += " / <a href='javascript:void(0)' onclick='enable_oekaki(); return false;'>"+_("Oekaki")+"</a>";

      $("#confirm_oekaki_label").hide();
    }
    if (enabled_tegaki) {
      my_html += " / <a href='javascript:void(0)' onclick='enable_tegaki(); return false;'>"+_("Tegaki")+"</a>";
    }
    if (enabled_jspaint) {
      my_html += " / <a href='javascript:void(0)' onclick='enable_jspaint(); return false;'>"+_("JS Paint")+"</a>";
    }
    if (enabled_voice) {
      my_html += " / <a href='javascript:void(0)' onclick='enable_voice(); return false;'>"+_("Voice")+"</a>";
    }
    if (enabled_poll) {
      my_html += " / <a href='javascript:void(0)' onclick='enable_poll(); return false;'>"+_("Poll")+"</a>";
    }
    $("#upload_selection").html(my_html);

    enable_file();
  }
});
