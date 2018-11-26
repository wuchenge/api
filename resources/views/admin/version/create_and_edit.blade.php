<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">创建</h3>

        <div class="box-tools">
            <div class="btn-group pull-right" style="margin-right: 10px">
                <a href="{{route('versions.index')}}" class="btn btn-sm btn-default"><i class="fa fa-list"></i>&nbsp;列表</a>
            </div> <div class="btn-group pull-right" style="margin-right: 10px">
                <a href="{{route('versions.index')}}" class="btn btn-sm btn-default form-history-back"><i class="fa fa-arrow-left"></i>&nbsp;返回</a>
            </div>
        </div>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
        @if($version->id)
            <form id="version_form" method="put" action="{{route('versions.update', $version->id)}}" class="form-horizontal">
            <input type="hidden" name="id" value="{{$version->id}}">
        @else
            <form id="version_form" method="post" action="{{route('versions.store')}}" class="form-horizontal">
        @endif
            {{csrf_field()}}
        <div class="box-body">

            <div class="fields-group">

                <div class="form-group  ">

                    <label for="version" class="col-sm-2  control-label">版本号<i style="color:red;"> *</i></label>

                    <div class="col-sm-8">

                        <div class="input-group">

                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>

                            <input type="text" id="version" name="version" value="{{old('version', $version->version)}}" class="form-control version" placeholder="版本号">

                        </div>

                    </div>
                </div>

                <div class="form-group  ">

                    <label for="type" class="col-sm-2  control-label">平台<i style="color:red;"> *</i></label>

                    <div class="col-sm-8">

                        <select required class="form-control" id="type" name="type">
                            <option value=""></option>
                            <option @if($version->type == 1) selected @endif  value="1">ios</option>
                           <option @if($version->type == 2) selected @endif  value="2">android</option>
                        </select>

                    </div>
                </div>

                <div class="form-group  ">

                    <label for="language" class="col-sm-2  control-label">语种<i style="color:red;"> *</i></label>

                    <div class="col-sm-8">

                        <select required class="form-control" id="language" name="language">
                            <option value=""></option>
                            @foreach ($languages as $key => $val)
                            <option @if($key == $version->language) selected="selected" @endif value="{{$key}}">{{$val}}</option>
                            @endforeach
                        </select>

                    </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">* 更新地址:</label>
                  <div class="col-sm-8">

                    <input type="file" name="file" id="pic">

                    <input type="text" style="margin-top: 10px;" class="form-control" id="avathors" name="url" value="{{ old('url', $version->url) }}">

                  </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">强制更新<i style="color:red;"> *</i></label>
                    <div class="col-sm-10">
                        <label class="checkbox-inline">
                          <input
                            type="radio"
                            value="1"
                            name="status"
                            @if($version->status == 1)
                                checked="checked"
                            @endif
                            > 否
                        </label>
                        <label class="checkbox-inline">
                          <input
                            type="radio"
                            value="2"
                            name="status"
                            @if($version->status == 2)
                                checked="checked"
                            @endif
                          > 是
                        </label>
                    </div>
                </div>

                <div class="form-group  ">

                    <label for="intro" class="col-sm-2  control-label">更新说明<i style="color:red;"> *</i></label>

                    <div class="col-sm-8">

                        <textarea class="form-control" name="intro" placeholder="更新说明">{{ old('intro', $version->intro) }}</textarea>

                    </div>
                </div>


            </div>

        </div>
        <!-- /.box-body -->
        <div class="box-footer">

            <div class="col-md-2">

            </div>
            <div class="col-md-8">

                <div class="btn-group pull-right">
                    <button onclick="submit_form()" type="button" class="btn btn-info pull-right" data-loading-text="<i class='fa fa-spinner fa-spin '></i> 提交">提交</button>
                </div>

                <div class="btn-group pull-left">
                    <button type="reset" class="btn btn-warning">重置</button>
                </div>

            </div>

        </div>


        <!-- /.box-footer -->
    </form>
</div>

<link rel="stylesheet" href="{{asset('vendor/laravel-admin/bootstrap-fileinput/css/fileinput.min.css')}}">
<script src="{{asset('vendor/laravel-admin/bootstrap-fileinput/js/fileinput.min.js')}}"></script>
<!-- <script src="{{asset('fileinput/fileinput_locale_zh.js')}}"></script> -->
<script type="text/javascript">
    //FILEINPUT
    // let url = "{{url('/common/upload/qiniu')}}";
    // let url = "{{url('/common/upload/local')}}";
    // let url = "http://up.qiniu.com";
    let url = "https://upload-z0.qbox.me";
    $(function() {
        //初始化控件
        initFileInput('pic', url);

        //控件上传返回
        $("#pic").on("fileuploaded", function (event, data, previewId, index) {
            if(data.response)
            {
              $('#avathors').val(data.response.key);
            }
        });

        //删除图片
        $(document).on('click', '.fileinput-remove-button', function() {
            $('#avathors').val('');
        });
    });

    //初始化fileinput控件（第一次初始化）
    function initFileInput(ctrlName, uploadUrl) {
        let control = $('#' + ctrlName);
        control.fileinput({
            language                : 'zh', //设置语言
            uploadUrl               : uploadUrl, //上传的地址
            uploadAsync: true, // 默认异步上传
            overwriteInitial: false,
            allowedFileExtensions   : ['apk', 'png', 'jpg'],//接收的文件后缀
            showUpload              : true, //是否显示上传按钮
            showCaption             : false,//是否显示标题
            browseClass             : "btn btn-primary", //按钮样式
            enctype                 : 'multipart/form-data',
            previewFileIcon         : "<i class='glyphicon glyphicon-king'></i>",
            browseClass             : "btn btn-primary", //按钮样式
            dropZoneEnabled         : false,//是否显示拖拽区域
            minFileCount      : 0,
            maxFileSize             : 200000,//单位为kb，如果为0表示不限制文件大小
            maxFileCount      : 10, //表示允许同时上传的最大文件个数
            msgFilesTooMany     : "选择上传的文件数量({n}) 超过允许的最大数值{m}！",
            validateInitialCount    : true,
            uploadExtraData         : function(previewId, index) {
                //额外参数的关键点,只能原生JS获取
                let obj = {
                    // _token  : "{{csrf_token()}}",
                    token  : "{{$qiniu_token}}",
                };
                return obj;
            },
            previewFileIcon         : "<i class='glyphicon glyphicon-king'></i>",
        });
    }


    //laravel-admin扩展起来很麻烦，最后考虑直接ajax提交表单了
    function submit_form() {
        var formData = $("#version_form").serialize();
        var url = $("#version_form").attr('action');
        var method = $("#version_form").attr('method');

        $.ajax({
            type:method,
            url:url,
            dataType:'json',
            data:formData,
            success:function (data) {
                //code是200并且有输出进入这里
                swal({
                    title:"操作成功",
                    text:"OK",
                    type:"success",
                    // showCancelButton:true,
                    // confirmButtonText:"继续添加",
                    // cancelButtonText:"返回列表",
                    // closeOnConfirm:false,
                    // closeOnCancel:false,
                },function(isConfirm){

                    })
                .then(() => {
                    $.pjax({container:'#pjax-container', url: '/admin/versions' });
                });

            },
            error:function (msg) {

                /*
                1.状态码不是200
                2. 返回数据类型不是JSON
                3. 网络中断
                4. 后台响应中断
                */
                if (msg.status == 422) {
                    console.log(msg.responseJSON.errors);
                    var obj = msg.responseJSON.errors;
                    var html = '';
                    Object.keys(obj).forEach(function(key){
                        html+=obj[key].join();
                    });
                    swal(html, '', 'error');
                } else if(msg.responseJSON) {
                    swal(msg.responseJSON.msg,'', 'error');
                } else {
                    swal('系统内部错误', '', 'error');
                }

            }
        })

    }
</script>
