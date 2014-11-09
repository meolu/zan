
var data_host = '/service/loadmd/';
var content_gateway = '/service/sync/';

var T, current_post_dom, controls;
var site_id, service;
var editor_model;
var c_hidden_left = -235;


function get_today_str(){
    var now = new Date();
    var year = now.getFullYear().toString();
    var month = (now.getMonth()+1).toString();
    var day = now.getDate().toString();
    if (month.length == 1) month = '0'+month;
    if (day.length == 1) day = '0'+day;
    return year + '-' + month + '-' + day
}


function load_data(){
    var request_data = {};
    $.getJSON(data_host+'?site_id='+site_id, request_data, function(data){
        $.each(data.posts, function(i, post){
            editor_model.posts.push(new Post(post))
        });

        editor_model.init_editor();
    });
}

var Post = function(raw_post){
    this.title = raw_post.md_id;
    this.content = raw_post.raw_content || '';

    // this.site_id = site_id || (raw_post.service + '#' + raw_post.uid + '#' + raw_post.site_path);
    // this.path = raw_post.path;
    // this.title = raw_post.path.substring(raw_post.path.lastIndexOf('/')+1, raw_post.path.lastIndexOf('.'));
    // this.object_id = raw_post["_id"] ? raw_post["_id"]["$oid"]:'';
    // this.id = raw_post.id;
    // this.raw_metadata_str = raw_post.metadata ? raw_post.metadata.raw_metadata_str: '';
    // this.content = raw_post.raw_content || '';


    this.edit = function(hide_controls_duration){
        editor_model.sync();

        var content_for_editor = this.content;
        T.val(content_for_editor);

        hide_controls(hide_controls_duration);

        if (current_post_dom){/*clear first*/
            current_post_dom.removeClass('current')
        }
        var index = $.inArray(this, editor_model.posts());
        current_post_dom = $($('#posts li a')[index]);
        current_post_dom.addClass('current');

        editor_model.current_post(this);
        editor_model.editor_text_length($.trim(content_for_editor).length);
        editor_model.text_length_changed(0); /*reset*/
        editor_model.show_preview(this.object_id);

        T.focus();

    }.bind(this);

};


var editorModel = function() {
    var self = this;

    self.posts = ko.observableArray([]);
    self.current_post = ko.observable({});
    self.editor_text_length = ko.observable(0);
    self.text_length_changed = ko.observable(0);
    self.has_new_post = false;

    self.show_preview = ko.observable(false);

    self.preview_url = ko.computed(function(){
        if (self.show_preview()){
             return '/service/gateway/post_redirect/'+self.current_post().object_id
        }
        else{
            return '#'
        }
    });

    self.manager_url = ko.computed(function(){
        if (service == 'dropbox'){
            return 'https://www.dropbox.com/'
        }
        else if (service == 'google')
        {
            return 'https://drive.google.com/'
        }
        else{
            return '#'
        }
    });

    self.init_editor = function(){
        var title = get_today_str();
        var titles = $.map(self.posts(), function(post){return post.title});
        if ($.inArray(title, titles) == -1){
            self.create_post();
        }
        else{
            self.posts()[0].edit();
        }

        $('#textarea').focus();
    };

    self.create_post = function(){
        if (!self.has_new_post){ /*not allowed to create 2+ new posts before synced to server*/
            var i = 0;
            var titles = $.map(self.posts(), function(post){return post.title});
            while(i<10){
                var title = get_today_str();
                if (i) title = title + '-' + i; /*not first one*/
                if ($.inArray(title, titles) == -1){ /*not contain this title, valid */
                    break
                }
                else{
                    i += 1
                }
            }
            var new_post = new Post({path: title+'.txt'});
            self.posts.unshift(new_post);
            new_post.edit(700);
            self.has_new_post = true;

        }
        else if(self.current_post()!=self.posts()[0]){ /*jump from other post*/
            self.posts()[0].edit();
        }
        else{ /*current is the new post, just hide*/
            hide_controls();
            T.focus();
        }


    };

    self.count_editor_text_length = function(){
        var current_length = $.trim($('#textarea').val()).length;

        var rate = 1;
        if (current_length<20){
            rate = 6
        }
        else if (current_length<50){
            rate = 3.0
        }
        else if (current_length<100){
            rate = 1.5
        }
        else if (current_length>1500){
            rate = 0.8
        }
        else if (current_length > 3000){
            rate = 0.7
        }

        var diff = Math.abs(current_length-self.editor_text_length());
        var total_changed = diff*rate + self.text_length_changed();

        /* update the values */
        self.editor_text_length(current_length);
        self.text_length_changed(total_changed);
    };

    /*auto sync script*/
    self.text_length_changed.subscribe(function(length){
        if (length > 100){
            self.sync();

        }
    });

    self.sync = function(){
        /*
        1, textarea发生变化
        2，edit的时候（包括edit当前的文章）
        3，浏览点击的时候
        4，关闭浏览器的时候
        */
        if (self.text_length_changed() == 0){
            return false;/*不需要处理*/
        }

        if (self.block){
            return false
        }

        var raw_content = $('#textarea').val();
        if (!$.trim(raw_content)){
            return false;
        }

        var post_on_edit = self.current_post();

        self.block = true;

        $.post(
            content_gateway,
            {
                site_id: post_on_edit.site_id,
                id: post_on_edit.id,
                type: 'post',
                path: post_on_edit.path,
                raw_content: raw_content
            },
            function(raw_post, status){
                if (status  == 'success'){
                    $.extend(post_on_edit, new Post(raw_post));

                    if (!post_on_edit.id){
                        self.has_new_post = false;
                        self.show_preview(true);
                    }
                }
                self.block = false; /*unblock now*/
                self.text_length_changed(0);
            }

        );

        return false
    };



 };



function show_controls(){
    if (controls.position().left == c_hidden_left){
        controls.animate({
            left: 0,
            opacity: 1
        }, 350, 'swing');

        if ($.browser.msie){
            $('#textarea').blur()
        }
    }

}

function hide_controls(duration){
    if (controls.position().left == 0){
        controls.animate({
            left: c_hidden_left,
            opacity: 0.3
        }, duration||500, 'swing');

        if ($.browser.msie){
            $('#textarea').focus()
        }
    }
}


function make_textarea_center(){
    /*textarea width is 750*/
    var T_width = 780;
    var padding = ($(document).width() - T_width)/2;
    T.css({"padding-right": padding+'px', 'width': T_width + padding + 'px'});
    if ($.browser.mozilla){/*firefox*/
        T.css({'width': T_width + 'px'});
    }
}


function run_editor(sid, serv){
    service = serv;
    site_id = sid;
    editor_model = new editorModel();

    $(document).ready(function(){
        T = $('#textarea');
        controls = $('#controls');

        hide_controls();
        make_textarea_center();

        load_data();
        ko.applyBindings(editor_model);
        controls.mouseenter(show_controls);
        controls.mouseleave(hide_controls);

    });

    window.onresize = make_textarea_center;

    window.onbeforeunload = function() {
        var message = '当前文章正在保存中，稍等片刻，请不要刷新或退出页面。';
        if (editor_model.text_length_changed() !=0 ){
            editor_model.sync();
            return message
        }
    };

}
