<?php
/**
 * Created by PhpStorm.
 * User: andreasfi
 * Date: 27.09.16
 * Time: 15:18
 */
include_once ROOT_DIR.'views/header.inc';
?>

    <section id="form_container" class="col-lg-12">

        <!-- Formulaire de contact -->

        <div class="cwell col-md-5">
            <h3 class="title">Formulaire de contact</h3>

            <div class="form">
                <form class="form-horizontal">
                    <!-- Name -->
                    <div class="form-group">
                        <label class="control-label col-md-3" for="name">Nom</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="name" maxlength="40">
                        </div>
                    </div>
                    <!-- Email -->
                    <div class="form-group">
                        <label class="control-label col-md-3" for="email">Adresse e-mail</label>
                        <div class="col-md-9">
                            <input type="email" class="form-control" id="email">
                        </div>
                    </div>
                    <!-- Message -->
                    <div class="form-group">
                        <label class="control-label col-md-3" for="message">Message</label>
                        <div class="col-md-9">
                            <textarea class="form-control" id="message" rows="4"></textarea>
                        </div>
                    </div>
                    <!-- Buttons -->
                    <div class="form-group">
                        <!-- Buttons -->
                        <div class="col-md-9 col-md-offset-3">
                            <button type="submit" class="btn btn-info">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-2">
            OR
        </div>

        <!-- Laisser un message audio-visuel -->
        <div class="cwell col-lg-5">
            <!-- Address section -->

            <div id="message_audio_visuel" class="col-lg-12">
                <div id="video_container">
                    <div id="button_container" class="col-lg-offset-1 col-lg-10">
                        <i class="fa fa-video-camera" aria-hidden="true"
                           style="font-size: 40px; color: dodgerblue; display: block;"></i>
                        <button id="button_message_visuel" type="button" class="btn btn-info" onclick="display_video()">
                            Laisser un message audio-visuel
                        </button>
                    </div>
                    <div id="webcam_video_container" style="display: none;">
                        <video id="webcam_video"></video>
                        <div id="webcam_video_controls">
                            <ul>
                                <li>
                                    <button id="start_recording" onclick="start_recording()"><i class="fa fa-circle"
                                                                                                style="color: red"> </i>
                                    </button>
                                </li>
                                <li>
                                    <button id="pause_recording" onclick="pause_recording"><i class="fa fa-pause"
                                                                                              aria-hidden="true"></i>
                                    </button>
                                </li>
                                <li>
                                    <button id="stop_recording" onclick="stop_recording()"><i class="fa fa-stop"
                                                                                              aria-hidden="true"></i>
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <div id="webcam_after_stop" style="display: none;">
                            <ul>
                                <li>
                                    <button id="button_video_preview" data-toggle="modal" data-target="#modal_video_preview" class="btn btn-info">Preview</button>
                                </li>
                                <li>
                                    <button id="button_video_retry" class="btn btn-info">New video</button>
                                </li>
                                <li>
                                    <button id="button_video_send" class="btn btn-info">Send</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Modal -->
        <div class="modal fade" id="modal_video_preview" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Video preview</h4>
                    </div>
                    <div class="modal-body">
                        <video autoplay id="video_preview" src="#" style="background-color: green;"></video>
                        <p>That's your video guy !</p>
                    </div>
                    <div class="modal-footer">
                        <ul>
                            <li>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </li>
                            <li>
                                <button type="button" class="btn btn-info">Preview</button>
                            </li>
                            <li>

                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>






        <script>

            var index = 0;
            var mediaRecorder = null;
            var video = document.querySelector('video');
            var mediaConstraints = {
                audio: true,
                video: true
            };

            function hasGetUserMedia() {
                return !!(navigator.getUserMedia || navigator.webkitGetUserMedia ||
                navigator.mozGetUserMedia || navigator.msGetUserMedia);
            }

            if (hasGetUserMedia()) {
                console.log("Success : Webcam/micro are supported.");
            } else {
                console.log("Error : Webcam/micro are not supported");
            }

            var errorCallback = function (e) {
                alert('Rejected', e);
            };


            function camera_on() {
                navigator.getUserMedia(mediaConstraints, function (localMediaStream) {

                    video.src = window.URL.createObjectURL(localMediaStream);
                    video.autoplay = true;

                    video.onloadedmetadata = function (e) {
                        // Ready to go. Do some stuff.
                    };

                }, errorCallback);
            }


            function display_video() {
                //0. Remove the current content
                $('#button_container').hide();
                //1. Append the video to message_audio_visuel
                $('#webcam_video_container').show();
                camera_on();
            }

            function start_recording() {
                navigator.getUserMedia(mediaConstraints, onMediaSuccess, onMediaError);
                $('#start_recording').prop("disabled", true);
                $('#pause_recording').prop("disabled", false);
                $('#stop_recording').prop("disabled", false);

            }

            function pause_recording() {
                mediaRecorder.pause();
                $('#pause_recording').prop('disabled', true);
                $('#start_recording').prop('disabled', false);
                $('#stop_recording').prop('disabled', false);

            }

            function stop_recording() {
                mediaRecorder.stop()
                //mediaRecorder.stream.stop();

                $('#start_recording').prop("disabled", false);
                $('#pause_recording').prop("disabled", true);
                $('#stop_recording').prop("disabled", true);

                $('#webcam_after_stop').css('display', 'block');
            }


            function onMediaSuccess(stream) {
                mediaRecorder = new MediaStreamRecorder(stream);
                mediaRecorder.mimeType = 'video/webm';
                mediaRecorder.ondataavailable = function (blob) {
                    // POST/PUT "Blob" using FormData/XHR2
                    var blobURL = URL.createObjectURL(blob);
                    appendLink('' + blobURL + '');
                };
                mediaRecorder.start(10000);
            }

            function onMediaError(e) {
                console.error('media error', e);
            }

            function appendLink(blob) {
                var a = document.createElement('a');
                a.target = '_blank';
                a.innerHTML = 'Open Recorded ' + (blob.type == 'audio/ogg' ? 'Audio' : 'Video') + ' No. ' + (index++) + ' (Size: ' + bytesToSize(blob.size) + ')';
                a.href = blob;

                alert(blob.length);

                $('#video_preview').attr("src", blob);
                $('#video_preview').prop('controls', true);
                //$('#links').append(a);
                //$('#links').append(document.createElement('hr'));

                //Stop the video
                stop_recording();

                console.log($("#video_preview"));


            }


        </script>


    </section>


<?php include_once ROOT_DIR . 'views/footer.inc';
?>