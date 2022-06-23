package com.example.tradestrategy.bean;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

public class SavesetHelper extends SQLiteOpenHelper {

    private final static int VERSION = 1;                //数据库版本
    private final static String DB_NAME = "saveset.db";  //数据库名

    private final static String CREATE_TBL="create table saveset (id integer primary key autoincrement,"
            +"name text,"
            +"notifylevel text,"
            +"loss text,"
            +"controlamount text,"
            +"price text,"
            +"flag text)";

    private SQLiteDatabase db; //数据库实例

    /*SQLiteOpenHelper子类必须有一个构造方法
   * context：上下文
   * name：数据库的名字
   * factory：设计模式
   * version：数据库的版本*/

    public SavesetHelper(Context context, String dbname, SQLiteDatabase.CursorFactory factory, int version) {
        super(context, dbname, factory, version);
    }
    public SavesetHelper(Context context, String dbname, int version) {
        super(context, dbname, null, version);
    }
    public SavesetHelper(Context context) {
        super(context, DB_NAME,null, VERSION);
    }


    @Override
    public void onCreate(SQLiteDatabase sqLiteDatabase) {
        this.db=sqLiteDatabase;   //拿到这个对象，然后就可以进行增删查改等操作
        db.execSQL(CREATE_TBL);  //创建表
    }

    //更新数据库版本
    @Override
    public void onUpgrade(SQLiteDatabase sqLiteDatabase, int i, int i1) {

    }

    public void insert(ContentValues values, String dbname){
        //获取到SQLiteDatabase对象
        SQLiteDatabase db = getWritableDatabase();
        //插入数据到数据库：insert方法
        db.insert(dbname,null,values);
        db.close();
    }
    //查询数据
    public Cursor query(String dbname){
        //获取到SQLiteDatabase对象
        SQLiteDatabase db=getReadableDatabase();
        //获取Cursor
        Cursor cursor=db.query(dbname,null,null,null,null,null,null);
        return cursor;
    }

    //删除数据
    public void delete(int id,String dbname){
        //获取到SQLiteDatabase对象
        SQLiteDatabase db=getReadableDatabase();
        db.delete(dbname,"id=?",new String[]{String.valueOf(id)});
        db.close();
    }

    //修改数据:dbname表名，
    public void update(String dbname,ContentValues values, String whereClause, int id){
        //获取到SQLiteDatabase对象
        SQLiteDatabase db=getReadableDatabase();
        db.update(dbname,values,whereClause,new String[]{String.valueOf(id)});
        db.close();
    }

    public void update_uid(ContentValues values, String[]whereArgs, String dbname){
        //获取到SQLiteDatabase对象
        SQLiteDatabase db=getReadableDatabase();
        db.update(dbname,values,"id=?",whereArgs);
        db.close();
    }
    public void close(){
        if (db!=null&&db.isOpen()){
            db.close();
            db = null;
        }
    }
}
