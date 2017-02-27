@extends('admin.layouts.base')
@section('content')
<section class="Hui-article-box">
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员管理 <span class="c-gray en">&gt;</span> 权限管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="Hui-article">
        <article class="cl pd-20">

            <div class="cl pd-5 bg-1 bk-gray mt-20">
                <span class="l">
                    @if($datas['cid']==0)
                    <a href="{{route('admin.permission.create',$datas['cid'])}}"  class="btn btn-primary radius">
                        <i class="Hui-iconfont">&#xe600;</i> 添加顶级权限节点
                    </a>
                    @else
                        <a href="{{route('admin.permission.create',$datas['cid'])}}"  class="btn btn-primary radius">
                            <i class="Hui-iconfont">&#xe600;</i> 添加子权限节点
                        </a>
                    @endif
                </span>
                    <span class="r">共有数据：<strong>{{$datas['count']}}</strong> 条</span>
            </div>
            <table class="table table-border table-bordered table-bg">
                <thead>
                <tr>
                    <th scope="col" colspan="8">权限节点</th>
                </tr>
                <tr class="text-c">
                    <th width="40">权限名称</th>
                    <th width="40">字段名</th>
                    <th width="40">权限描述</th>
                    <th width="40">图标</th>
                    <th width="40">创建时间</th>
                    <th width="40">修改时间</th>
                    <th width="40">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($datas['data'] as $value)

                    <tr class="text-c">
                        <td width="40">{{$value->name}}</td>
                        <td width="40">{{$value->label}}</td>
                        <td width="40">{{$value->description}}</td>
                        <td width="40">{{$value->icon}}</td>
                        <td width="40">{{$value->created_at}}</td>
                        <td width="40">{{$value->updated_at}}</td>
                        <td width="40">
                            @if($value->cid == 0)
                            <a title="下级权限" href="{{url('admin/permission/index/'.$value->id)}}" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe60c;</i></a>
                            @endif
                            <a title="编辑" href="javascript:;" onclick="admin_permission_edit('角色编辑','{{url('admin/permission/'.$value->id.'/edit')}}','1','','310')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
                            <a title="删除" href="javascript:;" onclick="admin_permission_delete('{{$value->id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
                        </td>
                    </tr>

                @endforeach
                </tbody>


            </table>
        </article>
    </div>
</section>
 @endsection

    @section('my-js')
        <script>
        function admin_permission_edit(title,url){
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }
        function admin_permission_delete(id){

            layer.confirm('你却定要删除当前的权限吗？',
                {
                    btn:['确定','取消']
                },
                    function(){
                        $.ajax({
                        dataType:'json',
                        url:'{{url('admin/permission/delete')}}/'+id,
                        type:'get',
                        success:function(data)
                        {
                        if(data.status == 1){
                            layer.msg(data.msg,{icon:2,time:2000});
                            window.location.href = window.location.href;
                        }
                        },
                        error:function(data)
                        {
                        console.log(data.status);
                        if(data.status === 422){
                        var errors = $.parseJSON(data.responseText);

                        var msg = "";
                        $.each(errors,function(index,value){

                        msg += value[0]+" "
                        });
                        layer.msg(msg,{icon:2,time:2000});
                        return;
                        }
                        layer.msg('服务器错误',{icon:2,time:2000});
                        }
                        });
                    },
                    function(){


                    }
            );

        }
        </script>

    @endsection
