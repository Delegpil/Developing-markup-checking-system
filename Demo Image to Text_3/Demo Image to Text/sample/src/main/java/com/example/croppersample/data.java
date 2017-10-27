package com.example.croppersample;

import android.app.AlertDialog;
import android.content.Intent;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.app.Activity;
import android.database.Cursor;
import android.view.Menu;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;
import com.example.croppersample.DBAdapter;
public class  data  extends Activity {
    DBAdapter myDb;
    Button btnAddData;
    Button btnviewAll;
    TextView textView1;
    @Override
    protected void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_data);
        myDb = new DBAdapter(this);
        btnAddData = (Button)findViewById(R.id.button1);
        btnviewAll = (Button)findViewById(R.id.button2);
        AddData();
        viewAll();
    }
    public  void AddData() {
        btnAddData.setOnClickListener(
                new View.OnClickListener()
                {
                    @Override
                    public void onClick(View v)
                    {
                        Intent intent = getIntent();
                        String strTemp = intent.getStringExtra("tempstring");
                        textView1 = (TextView) findViewById(R.id.test);
                        textView1.setText(strTemp);
                        String[] line = strTemp.split("\n");
                        for (int i = 0; i < line.length; i++)
                        {
                            String[] words = line[i].split(" ");

                            boolean isInserted = myDb.insertData( words[0], words[1],   words[2] );
                            if(isInserted == true)
                                Toast.makeText(getBaseContext(),"Утга орлоо",Toast.LENGTH_LONG).show();
                            else
                                Toast.makeText(getBaseContext(),"алдаа ",Toast.LENGTH_LONG).show();
                        }

                    }
                }
        );
    }

    public void viewAll() {
        btnviewAll.setOnClickListener(
                new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        Cursor res = myDb.getAllData();
                        if(res.getCount() == 0) {
                            // show message
                            showMessage("Error","өгөгдөл алга");
                            return;
                        }

                        StringBuffer buffer = new StringBuffer();
                        while (res.moveToNext())
                        {
                            buffer.append("Дугаар: "+ res.getString(0)+"\n");
                            buffer.append("Код: "+ res.getString(1)+"\n");
                            buffer.append("Нэр: "+ res.getString(2)+"\n\n");
                        }

                        // Show all data
                        showMessage("Мэдээлэл",buffer.toString());
                    }
                }
        );
    }

    public void showMessage(String title,String Message){
        AlertDialog.Builder builder = new AlertDialog.Builder(this);
        builder.setCancelable(true);
        builder.setTitle(title);
        builder.setMessage(Message);
        builder.show();
    }


}