<!DOCTYPE html>
    <section style="width: 80%;margin: auto;height:600px;box-shadow: 0 0 10px #e6e6e6;color: grey;">
        <div id="head_1" style="background: #e6e6e6; height: 80px;">
        <h2 style="margin: 0;padding: 25px;color: skyblue;background: #e6e6e6;font-family:sans-serif;font-weight: bold;">PrimedPoll</h2><br><br>
        </div>

        <div id="box" style="width: 95%; margin: auto;"><br>
            <h4>Dear <b>{{$user->name}}</b></h4>
            <div id="third_block">
                    <p>Your new password is <h4>{{$user->password}}</h4></p>

                    <p>Please do well to change this password to once you are logged in....</p><br><br>

                    <h5 style="text-align:right;">PrimedPoll Team</h5>
            </div>
        </div>
    </section>
</html>
