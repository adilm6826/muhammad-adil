<!DOCTYPE html>
<html>
    <head>
        <title>Techswivel - Task 0 - 0.2</title>
        <!-- ✅ load jQuery ✅ -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-md-6">
                    <form action="{{route('frist-form.remove-space')}}" method="POST" id="message-form">
                        @csrf
                        <!-- Heading -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="form4Example1"><h2>Form with TextArea </h2></label>
                        </div>

                        <!-- Message input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="message">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="4">{{old('message')}}</textarea>
                        </div>
                        @error('message')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                        
                        <!-- Submit button -->
                        <div class="form-outline mb-4">
                            <button type="reset" class="btn btn-success btn-block mb-4">Reset</button>
                            <button type="submit" class="btn btn-primary btn-block mb-4">Send</button>
                        </div>
                    </form>

                    {{-- Display cleaned space of the message if it exists --}}
                    @if(session('cleanedMessage'))
                        <div class="form-outline mb-4">
                            <b>Orginal Message is: </b><p class="text text-justify">{{ session('originalMessage') }}</p>
                            <b>Message After Removing Space is: </b><p class="text text-justify">{{ session('cleanedMessage') }}</p>

                            {{-- The word <b>{{session('word')}}</b>: appears <strong>{{ session('wordCount') }}</strong> times in the paragraph.
                            <p>
                                <h6>Given Paragraph is:</h6>
                                {{session('message')}}
                            </p> --}}
                        </div>
                    @endif
                    {{-- @if(Session::has('cleanedMessage'))
                        <div class="form-outline mb-4">
                            <b>Orginal Message is: </b><p class="text text-justify">{{ Session::get('originalMessage') }}</p>
                            <b>Message After Removing Space is: </b><p class="text text-justify">{{ Session::get('cleanedMessage') }}</p>
                        </div>
                    @endif --}}
                </div>
            </div>
        </div>       

        {{-- Begin: Script to Validate the form Using Jquery validation --}}
        <script>
            $(document).ready(function(){
                $("#message-form").submit(function(e){
                    // Remove the previous error alerts
                    $(".alert-danger").remove();
                    // 
                    let message = $("#message").val();
                    if(message.trim()==="" || message === null || message.length ==0){
                        e.preventDefault();
                        $("#message").after('<div class="alert alert-danger">Message Should be provided</div>');
                    }
                });
            });
        </script>
        {{-- End: Script to Validate the form Using Jquery validation --}}
    </body>
</html>