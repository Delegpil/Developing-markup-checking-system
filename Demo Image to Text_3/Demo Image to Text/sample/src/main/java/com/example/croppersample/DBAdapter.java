package com.example.croppersample;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.SQLException;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;
import android.util.Log;

import static android.content.ContentValues.TAG;

public class DBAdapter extends SQLiteOpenHelper
{
    public static final String DATABASE_NAME = "database.db";
    public static final String TABLE_NAME = "student";
    public static final String COL_1 = "ID1";
    public static final String COL_2 = "code";
    public static final String COL_3 = "name";
    public static final String COL_4 = "date";
    public static final String COL_5 = "dun";

    public DBAdapter(Context context) {
        super(context, DATABASE_NAME, null, 13);
    }
    @Override
    public void onCreate(SQLiteDatabase db) {
        db.execSQL("create table " + TABLE_NAME +" (ID1 INTEGER PRIMARY KEY AUTOINCREMENT,code TEXT , name TEXT,  date TEXT,   dun integer)");
   }

    @Override
    public void onUpgrade( SQLiteDatabase db, int oldVersion, int newVersion)
    {
        db.execSQL("DROP TABLE IF EXISTS "+TABLE_NAME);
        onCreate(db);
    }

    public boolean insertData( String code,String name, String date)
    {
        SQLiteDatabase db = this.getWritableDatabase();
        ContentValues contentValues = new ContentValues();

            contentValues.put(COL_2, code);
            contentValues.put(COL_3, name);
            contentValues.put(COL_4, date);

    long result = db.insert(TABLE_NAME, null ,contentValues);
        if(result == -1)
            return false;
        else
            return true;
    }

    public Cursor getAllData()
    {
        SQLiteDatabase db = this.getWritableDatabase();
        Cursor res = db.rawQuery("select * from "+TABLE_NAME,null);
        return res;
    }


}