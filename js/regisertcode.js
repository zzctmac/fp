/**
 * Created by ZZC on 2016/10/18.
 */

var RegisterCode = {
    api : '/register/registercheckcode',
    validate: function(tel) {
        var res = true;
        do{
            if(!isTel(tel)) {res = '手机号不合法'; break;}
        }while (false);
        return res;
    },
    validTip: function(msg) {
        alert(msg);
    },
    makeData: function(tel) {
        return {
            tel:tel,
            agreement:hex_md5(tel + "mxe")
        };
    },
    callback:function(res) {
        if(res.code = 1) {
            Base.ver_code = res.VerificationCode;
        } else {
            alert(res.msg);
        }
    },
    action:function(tel) {
        var isValid = this.validate(tel);
        if(true !== isValid) {
            this.validTip(isValid);
            return ;
        }
        var data = this.makeData(tel);
        var url = base_url + this.api;
        var type = 'GET';
        var dataType = 'JSONP';
        $.ajax({
            url:url,
            type:type,
            dataType:dataType,
            data:data
        }).done(this.callback);
    }


};
