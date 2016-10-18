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