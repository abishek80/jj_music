// Generate Token
$(".generate_token").blur(function () {
    var string = $(this).val();
    var convertedString = string.replace(/[^a-zA-Z0-9\s]/g, "");
    var trimmedString = convertedString.trim();
    var url = trimmedString.replace(/\s+/g, '-').toLowerCase();
    if (url !== "") {
        $('#token').val(url);
    }
});

// private function sanitizeAndConvertToLower($string)
// {
//     $convertString = preg_replace('/[^a-zA-Z0-9\s]/', '', $string);
//     $convertString = strtolower($convertString);
//     $convertString = str_replace([' ', '-', '_'], '', $convertString);
//     return $convertString;
// }

// Generate Token while edit

$(".generate_token_edit").blur(function () {
    var string = $(this).val();
    var string = string.replace(/[^a-zA-Z ]/g, "");
    var next = string.trim();
    var url = next.replace(/ +/g, '').toLowerCase();
    if (url != "") {
        $('#edit_token').val(url);
    }
});

// Get Cookie 
function getCookie(name) {
    var cookieValue = null;
    if (document.cookie && document.cookie != '') {
      var cookies = document.cookie.split(';');
      for (var i = 0; i < cookies.length; i++) {
        var cookie = jQuery.trim(cookies[i]);
        // Does this cookie string begin with the name we want?
        if (cookie.substring(0, name.length + 1) == (name + '=')) {
            cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
            break;
        }
      }
    }
    return cookieValue;
}
var csrftoken = getCookie('csrftoken');