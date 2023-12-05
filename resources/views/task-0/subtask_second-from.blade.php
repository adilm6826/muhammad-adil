<!DOCTYPE html>
<html>
    <head>
        <title>Techswivel - Task 0 - 0.3</title>
        <!-- ✅ load jQuery ✅ -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-md-6">
                    <form action="{{route('second-form.count_words')}}" method="POST" id="message-form">
                        @csrf
                        <!-- Heading -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="form4Example1"><h2>Form with input and TextArea: To Count the Given Word </h2></label>
                        </div>

                        <!-- Input Title -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="word">Word</label>
                            <input type="text" class="form-control" id="word" name="word" value="{{old('word')}}" minlength="1" maxlength="255" oninput="validateWordInput()" placeholder="Enter Your Word Here to Count from the Given Paragraph:" />
                        </div>
                        @error('word')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                        
                        <!-- Message input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="message">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="5">{{old('message')}}</textarea>
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

                    {{-- Display word count of the message --}}
                    @if(session('wordCount'))
                        <div class="form-outline mb-4">
                            The word <b>{{session('word')}}</b>: appears <strong>{{ session('wordCount') }}</strong> times in the paragraph.
                            <p>
                                <h6>Given Paragraph is:</h6>
                                {{session('message')}}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>       

        {{-- Begin: Script to Validate the form Using Jquery validation --}}
        <script>
            // Begin: To Validate the word on input to don't enter the 2nd word
            function validateWordInput() {
                let wordInput = document.getElementById('word');
                let word = wordInput.value.trim();

                // Check if the word contains spaces
                if (word.includes(' ')) {
                    alert('Please provide only one word without spaces.');
                    wordInput.value = wordInput.value.replace(/\s/g, ''); // Remove spaces from the input
                }
            }
            // End: To Validate the word on input to don't enter the 2nd word

            // Begin: To Validate the Form
            $(document).ready(function(){
                $("#message-form").submit(function(e){
                    // Remove the previous error alerts
                    $(".alert-danger").remove();
                    // 
                    // To check the word field is empty or not
                    let word = $("#word").val();
                    if(word.trim()==='' || word===null || word.length==0){
                        e.preventDefault();
                        $("#word").after('<div class="alert alert-danger">Word should be given that you want to count from the below paragraph.</div>')
                    }

                    // To check the message field is empty or not
                    let message = $("#message").val();
                    if(message.trim()==="" || message === null || message.length ==0){
                        e.preventDefault();
                        $("#message").after('<div class="alert alert-danger">Message Should be provided</div>');
                    }
                });
            });
            // End: To Validate the Form

        </script>
        {{-- End: Script to Validate the form Using Jquery validation --}}
    </body>
</html>