/**
 * Created by ZZC on 2016/10/19.
 */


var Register = {
    formName: null,
    api: "/register/register",
    setFormName: function (formName) {
        this.formName = formName;
    },
    callback: function (res) {
        console.log(res);
        if (res.code == 1) {

        } else {
            alert(res.msg);
        }
    },
    setValidate: function () {
        var p = this;
        $(this.formName).validate({
            submitHandler: function (form) {   //表单提交句柄,为一回调函数，带一个参数：form
                var data = getFormJson(form);
                var type = "POST";
                var dataType = "JSON";
                var url = base_url + p.api;
                $.ajax({
                    url: url,
                    data: data,
                    type: type,
                    dataType: dataType
                }).done(p.callback);
            },
            rules: {
                realName: {required: true},
                tel: {required: true, rangelength: [11, 11]},
                checkCode: {required: true},
                pwd: {required: true, rangelength: [6, 16]}
            },
            messages: {
                realName: {required: "用户名必填"},
                tel: {required: "手机号码必填", rangelength: "手机号不合法"},
                checkCode: {required: "验证码必填"},
                pwd: {required: "密码必填", rangelength: "密码最小长度:6, 最大长度:16"}
            }
        });
    }
};