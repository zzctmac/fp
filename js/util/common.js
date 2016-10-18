/**
 * Created by ZZC on 2016/10/18.
 */

var base_url = 'http://mxe.fh25.com/api';

function isTel(tel) {
    var reg = /^0?1[3|4|5|8][0-9]\d{8}$/;
    if (reg.test(tel)) {
        return true;
    }else{
        return false;
    };
}

// ps:注意将同名的放在一个数组里
function getFormJson(form) {
    var o = {};
    var a = $(form).serializeArray();
    $.each(a, function () {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
}