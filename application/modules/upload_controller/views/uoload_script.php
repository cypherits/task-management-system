<?php
// $project = $this->session->userdata('project_info');
?>


<script type="text/javascript" defer>

    active_folder = 0;
    current_folder = '0'; // do not remove it form here 
    current_folder_file = '0';  //do not remove it form here 
    dataHtml = '';
    var tag_dialog = '';

    function uuid()
    {
        var chars = '0123456789abcdef'.split('');

        var uuid = [], rnd = Math.random, r;
        uuid[8] = uuid[13] = uuid[18] = uuid[23] = '-';
        uuid[14] = '4'; // version 4

        for (var i = 0; i < 36; i++)
        {
            if (!uuid[i])
            {
                r = 0 | rnd() * 16;

                uuid[i] = chars[(i == 19) ? (r & 0x3) | 0x8 : r & 0xf];
            }
        }

        return uuid.join('');
    }



    var progress_bar_init = function (i, name) {

        this.str = '<td  id="sl_' + i + '"></td>'; //this.str += '<td  width="100px !important;" class="truncate" id="run_name_' + i + '"></td>';
        this.str += '<td><div id="msg_me_' + i + '"><span id="txt_' + i + '"></span><br/><div class="progress" >';
        this.str += '<div class="progress-bar  progress-bar-success progress-bar-striped"  id="progressbar_' + i + '"';
        this.str += ' role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" ></div></div></td>';
        this.id_run = "run_1   > tbody:last-child";
        $('<tr/>', {
            'id': 'dyn_' + i,
            'html': this.str

        }).appendTo("#" + this.id_run);
        this.th_name = $("#sl_" + i);
        this.file_name = $("#run_name_" + i);
        this.Progressbar = $("#progressbar_" + i);
        this.msgtxt = $("#txt_" + i);

        this.th_name.html(i + 1);
        this.file_name.html(name);
        this.get_progressbar = function (done_now, cp_r, num_chunks, txt = '') {
            // this.msgtxt.text(cp_r+" upload Completed of "+  num_chunks );
            if (txt == '') {
                this.Progressbar.text(done_now + '%');
            } else {
                this.Progressbar.text(txt);
            }
            this.Progressbar.css('width', done_now + '%').attr('aria-valuenow', done_now);

        };
    };



    var Upload_process = function (value, localobject, uid) {

        this.value = value;

        this.localobject = localobject;



        this.NUM_CHUNKS = Math.max(Math.ceil(this.value.size / Fileupload.BYTES_PER_CHUNK), 1);

        var chunkint = this.NUM_CHUNKS;
        var cp_r = 1;
        this.chunkUpload = function (blob, num) {


            var xhr = new XMLHttpRequest();


            xhr.onreadystatechange = function () {
                var state = parseInt(xhr.readyState);

                if (state == 4) {

                    //    console.log('ok',xhr.responseText, Fileupload.settings.Current_folder, Fileupload.settings.Current_directory );
                    var obj = $.parseJSON(xhr.responseText);
                    var percentComplete = cp_r;
                    var done_now = percentComplete / chunkint;

                    var completed = Math.round(done_now * 100);
                    localobject.get_progressbar(completed, cp_r, chunkint);
                    cp_r++;
                    if (obj.pro === obj.total_chunks)
                    {

                        setTimeout(function () {

                            jQuery.ajax({
                                type: "POST",
                                url: "<?= base_url() ?>upload_controller/combine",
                                data: {uid: obj.uid, ext: obj.ext, old_name: obj.old_name, total_chunks: obj.total_chunks, folder_id: Fileupload.settings.Current_folder, directory: Fileupload.settings.Current_directory, current_folder: Fileupload.settings.current_folder},
                                success: function (res) {
                                    var response = jQuery.parseJSON(res);
                                    //  console.log(response);
                                    localobject.get_progressbar(100, chunkint, chunkint, response.txt);
                                    $('#upload_modal_close').show();
                                }
                            });

                        }, 3000);




                    }



                }
            };

//console.log(Fileupload.settings.Current_folder);
//return;
            var fd = new FormData();


            fd.append('upload', blob, this.value.name);

            fd.append('current_folder', Fileupload.settings.Current_folder);
            fd.append('current_directory', Fileupload.settings.Current_directory);
            fd.append('size', this.value.size);
            fd.append('num', num);
            fd.append('num_chunks', chunkint);
            fd.append('uid', uid);

//this.value.type

            xhr.open('POST', Fileupload.settings.post_url, true);

            xhr.send(fd);

        };  // chunkUpload finish here
    };

    var Fileupload = {
        Fileblob: new Array(),
        Filequee: new Array(),
        Progressbar: '',
        Global_msg: '',
        msg_txt: '',
        Global_count: 0,
        File_type: '',
        File_name: '',
        File_size: '',
        File_value: '',
        Perchunk: 1,
        BYTES_PER_CHUNK: parseInt(100000, 10), // 100 kb
        NUM_CHUNKS: 0,
        tb_x: 0,

        init: function (settings) {
            Fileupload.settings = settings;
        },
        reset: function (FSOBJ) {
            FSOBJ.Filequee = new Array();
            return;
        },
        readSettings: function () {

            Fileupload.settings.upload_area_id.on('dragover', function (e) {
                e.preventDefault();
                e.stopPropagation();
            });
            Fileupload.settings.upload_area_id.on('dragenter', function (e) {
                e.preventDefault();
                e.stopPropagation();
            });
            Fileupload.settings.upload_area_id.on('drop',
                    function (e) {
                        if (e.originalEvent.dataTransfer) {
                            if (e.originalEvent.dataTransfer.files.length) {
                                e.preventDefault();
                                e.stopPropagation();

                                /*UPLOAD FILES HERE*/
                                Fileupload.upload(e.originalEvent.dataTransfer.files);
                            }
                        }
                    }
            );
            Fileupload.settings.input_file_id.unbind('change');
            Fileupload.settings.input_file_id.on('change', function (e) {
                console.log('aa');
                Fileupload.upload(this.files);
            });

        },
        upload: function (files) {

            $("#copy_file").modal({
                backdrop: 'static',
                keyboard: false
            });

            $('#copy_file').on('hidden.bs.modal', function () {

                $(this).data('bs.modal', null);

            });
            var ins = files.length;

            var j = 0;

            for (j = 0; j < ins; j++)
            {

                if (typeof files[j] != 'undefined')
                {

                    var str_name = files[j].name;
                    Fileupload.Filequee[j] = files[j];


                }

            }
            if (j >= 5) {
                Fileupload.reset(Fileupload);
                $('#copy_file').modal('hide');
                bootbox.alert("You can upload at a time five file only.");
                return;

            }
            var new_array = $.map(Fileupload.Filequee, function (el) {
                return el !== '' ? el : null;
            });
            var x = 0;
            $.each(new_array, function (key, value) {
//var form_data = new FormData();


                if (typeof value != 'undefined') {

                    //  form_data.append("userfile",value);

                    var lobj = new progress_bar_init(Fileupload.tb_x, value.name);


                    Fileupload.tb_x++;

                    var start = 0;
                    var end = Fileupload.BYTES_PER_CHUNK;
                    var num = 1;
                    var uid = uuid();
                    var nty = new Upload_process(value, lobj, uid);
                    while (start < value.size) {

                        try {
                            nty.chunkUpload(value.slice(start, end, {type: "application/octet-stream"}), num);
                        } catch (err) {

                        }

                        start = end;

                        end = start + Fileupload.BYTES_PER_CHUNK;

                        num++;
                    }



                    //   Fileupload.process_upload();

                    Fileupload.Global_count++;

                }

            });


            return false;

        }


    };

    function trigger_file() {
        console.log('here');
        $("#file_id").trigger("click");
    }

    function  reinitiate() {




        Fileupload.init({
            post_url: "<?= base_url(); ?>upload_controller/index",
            upload_area_id: $(document),
            input_file_id: $("#file_id"),
            Current_directory: active_folder,
            Current_folder: current_folder_file

        });
        Fileupload.readSettings();
    }


    $(document).ready(function () {
        reinitiate();



        $('#copy_file').on('hidden.bs.modal', function () {

            location.reload();
        });





    });


</script>

