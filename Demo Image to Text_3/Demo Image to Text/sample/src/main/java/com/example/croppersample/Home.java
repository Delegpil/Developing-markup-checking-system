package com.example.croppersample;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

public class Home extends AppCompatActivity
{
    String name, password, email, Err;
    TextView nameTV, emailTV, passwordTV, err;
    Button button;

    @Override
    protected void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.home);

        nameTV = (TextView) findViewById(R.id.home_name);
        emailTV = (TextView) findViewById(R.id.home_email);
        passwordTV = (TextView) findViewById(R.id.home_password);
        err = (TextView) findViewById(R.id.err);
        button = (Button)findViewById(R.id.hometodbbtn);


        name = getIntent().getStringExtra("name");
        password = getIntent().getStringExtra("password");
        email = getIntent().getStringExtra("email");
        Err = getIntent().getStringExtra("err");

        nameTV.setText("Welcome " + name);
        passwordTV.setText("Your password is " + password);
        emailTV.setText("Your email is " + email);
        err.setText(Err);

        button.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View v)
            {
                Intent myIntent = new Intent(getApplicationContext(),  com.vish.imagetotext.ocr.sample.main.class);
                startActivity(myIntent);
            }
        });
    }
}
