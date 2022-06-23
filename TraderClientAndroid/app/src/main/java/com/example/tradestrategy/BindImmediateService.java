package com.example.tradestrategy;

import android.app.Service;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.content.ServiceConnection;
import android.content.SharedPreferences;
import android.os.Binder;
import android.os.Handler;
import android.os.IBinder;
import android.os.SystemClock;
import android.support.v4.content.LocalBroadcastManager;
import android.util.Log;

import com.example.tradestrategy.bean.CheckCodeData;
import com.example.tradestrategy.bean.Flagchange;
import com.example.tradestrategy.bean.SendUserinfo;
import com.example.tradestrategy.bean.Sendmessage;
import com.example.tradestrategy.http.ValidateUtil;
import com.google.gson.Gson;

import org.java_websocket.WebSocket;
import org.java_websocket.client.WebSocketClient;
import org.java_websocket.framing.Framedata;
import org.java_websocket.framing.FramedataImpl1;
import org.java_websocket.handshake.ServerHandshake;

import java.net.URI;
import java.net.URISyntaxException;
import java.util.Iterator;
import java.util.Timer;
import java.util.TimerTask;

import static com.lzy.okgo.utils.HttpUtils.runOnUiThread;

public class BindImmediateService extends Service {

    private static final String TAG = "BindImmediateService";
    private static WebSocketClient mWebSocketClient;
    private static SharedPreferences codeSettings;
    private static MainActivity.LocalReceiver localReceiver;
    private static LocalBroadcastManager localBroadcastManager;
    private static String INITIAL_MESSAGE = "android.example.myapplication_test1.RESPOND_VIA_MESSAGE";
    private static Handler handlers = new Handler();
    private static Timer timer = new Timer();
    private static int Flag_Internet = 0;//是否有网络
    private static Context context;
    private String activationcode;
    private String mac;
    private Boolean mRegisterTag = false; //全局定义一个是否注册广播的标志
    private String variety;
    private String wsApiInterFace = "ws://192.168.101.177:";
//    private String wsApiInterFace = "ws://192.168.2.168:";

    // 创建一个粘合剂对象
    private final IBinder mBinder = new LocalBinder();
    // 定义一个当前服务的粘合剂，用于将该服务黏到活动页面的进程中

    public class LocalBinder extends Binder {
        public BindImmediateService getService() {
            return BindImmediateService.this;
        }
    }

    public BindImmediateService() {

    }

    Timer newTm = new Timer();

    @Override
    public int onStartCommand(Intent intent, int flags, int startId) {
        return super.onStartCommand(intent, flags, startId);
    }

    @Override
    public IBinder onBind(Intent intent) {
        Log.d(TAG, "绑定服务开始旅程！");
        variety = intent.getStringExtra("varietydate");
        return mBinder;
    }

    public static void refresh(String text) {
        Log.d(TAG, text);
        Gson gson = new Gson();
        double unitprice = Double.parseDouble(codeSettings.getString("unitPrice", "100"));
        Sendmessage sendmessage_list = new Sendmessage("get_list", unitprice);
        String message_list = gson.toJson(sendmessage_list);
        mWebSocketClient.send(message_list);

        Sendmessage sendmessage_summary = new Sendmessage("get_summary", unitprice);
        String message_summary = gson.toJson(sendmessage_summary);
        mWebSocketClient.send(message_summary);

        sendmessage();
    }


    @Override
    public void onCreate() { // 创建服务
        super.onCreate();
        // Log.e("1111","创建服务");
        localBroadcastManager = LocalBroadcastManager.getInstance(this);
        codeSettings = getSharedPreferences("ActivationCode", MODE_PRIVATE);//MODE_PRIVATE 实时读取
        activationcode = codeSettings.getString("ActivationCode", "");
        mac = codeSettings.getString("MacCode", "");
        double unitprice = Double.parseDouble(codeSettings.getString("unitPrice", "100"));
        context = BindImmediateService.this;
        variety = codeSettings.getString("VarietyCode", "12315");
//        variety = "12315";
        try {
            mWebSocketClient = new MyWebSocketClient(wsApiInterFace + variety + "/");
            mWebSocketClient.connect();

            //默认状态：显示无网页面

//            while (!mWebSocketClient.getReadyState().equals(WebSocket.READYSTATE.OPEN)) {
//                System.out.println("还没有打开");
//                //睡眠1秒
//                SystemClock.sleep(1000);
//            }

            TimerTask ta = new TimerTask() {
                @Override
                public void run() {
                    if (mWebSocketClient.isClosed()) {
                        Log.e("trader", "mWebSocketClient isClosed");
                        mWebSocketClient.reconnect();
                    } else if (mWebSocketClient.isOpen()) {
                        Log.e("trader", "mWebSocketClient isOpend");
                    } else {
                        Log.e("trader status ", mWebSocketClient.getReadyState().toString());
                    }
                    Log.e("trader status out ", mWebSocketClient.getReadyState().toString());
                }
            };

            newTm.schedule(ta, 1000, 1000);


        } catch (URISyntaxException e) {
            e.printStackTrace();
        }
    }


    @Override
    public void onDestroy() { // 销毁服务
        //refresh("onDestroy");
        Log.e("trader", "service onDestroy()");
        if (mRegisterTag) {
            localBroadcastManager.unregisterReceiver(localReceiver);
            timer.cancel();

            mWebSocketClient.close();
            mRegisterTag = false;
            newTm.cancel();
        }
        super.onDestroy();
    }


    @Override
    public void onRebind(Intent intent) { // 重新绑定服务
        //refresh("onRebind");
        super.onRebind(intent);
    }

    @Override
    public boolean onUnbind(Intent intent) { // 解绑服务。返回false表示只能绑定一次，返回true表示允许多次绑定
        Log.d(TAG, "绑定服务结束旅程！");
        onDestroy();
        //refresh("onUnbind");
        return true;
    }


    public static void sendmessage() {
        TimerTask timerTask = new TimerTask() {
            @Override
            public void run() {
                handlers.post(new Runnable() {
                    @Override
                    public void run() {
                        if (ValidateUtil.isNetworkAvalible(context) && Flag_Internet == 1) {
                            Gson gson = new Gson();
                            double unitprice = Double.parseDouble(codeSettings.getString("unitPrice", "100"));
                            Sendmessage sendmessage_list = new Sendmessage("get_list", unitprice);
                            String message_list = gson.toJson(sendmessage_list);
                            try {
                                if (mWebSocketClient.isOpen()) {
                                    mWebSocketClient.send(message_list);

                                    Sendmessage sendmessage_summary = new Sendmessage("get_summary", unitprice);
                                    String message_summary = gson.toJson(sendmessage_summary);
                                    mWebSocketClient.send(message_summary);
                                }

                            } finally {
                                System.out.println("ws connect error 1");
                            }

                        } else {
                            timer.cancel();
                            Intent intent = new Intent(INITIAL_MESSAGE);
                            intent.putExtra("connecting_nointernet", "1");
                            localBroadcastManager.sendBroadcast(intent);
                        }
                    }
                });
            }
        };
        timer = new Timer();
        timer.schedule(timerTask, 0, 5000);
    }


    class MyWebSocketClient extends WebSocketClient {

        MyWebSocketClient(String url) throws URISyntaxException {
            super(new URI(url));
        }

        @Override
        public void onOpen(ServerHandshake handshakedata) {
            System.out.println("握手...");
            for (Iterator<String> it = handshakedata.iterateHttpFields(); it.hasNext(); ) {
                String key = it.next();
                System.out.println(key + ":" + handshakedata.getFieldValue(key));
            }


            System.out.println("建立websocket连接");

            Flag_Internet = 1;
            Gson gson = new Gson();

            //SendUserinfo sendUserinfo = new SendUserinfo("login",activationcode,mac);
//            SendUserinfo sendUserinfo = new SendUserinfo("login", "A12315", "A4:50:46:D7:74:02");
            SendUserinfo sendUserinfo = new SendUserinfo("login", activationcode, mac);
            String message_userinfo = gson.toJson(sendUserinfo);
            mWebSocketClient.send(message_userinfo);


        }

        @Override
        public void onMessage(String message) {
            System.out.println("接收到消息：" + message);

            if (message.contains("login")) {
                Gson gson = new Gson();
                CheckCodeData checkCodeData = gson.fromJson(message, CheckCodeData.class);
                //先将信息以广播形式发出：

                //广播：错误信息：前缀+错误信息
                if (!mRegisterTag) {
                    localReceiver = new MainActivity.LocalReceiver();
                    IntentFilter intentFilter = new IntentFilter();
                    intentFilter.addAction(INITIAL_MESSAGE);

                    //注册本地广播
                    localBroadcastManager.registerReceiver(localReceiver, intentFilter);

                    mRegisterTag = true;
                }

                String mistake_message = checkCodeData.getErrmsg();
                Intent intent = new Intent(INITIAL_MESSAGE);
                intent.putExtra("initialnews_login_mistake_message", mistake_message);
                localBroadcastManager.sendBroadcast(intent);

               /* Looper.prepare();
                Toast.makeText(MainActivity.this,checkCodeData.getErrmsg()+"",Toast.LENGTH_SHORT).show();
                Looper.loop();*/
            } else if (message.contains("get_list")) {
                //2、发送广播：
                Intent intent = new Intent(INITIAL_MESSAGE);
                intent.putExtra("initialnews_getlist_message", message);
                localBroadcastManager.sendBroadcast(intent);
                // show_getlist(message);
            } else if (message.contains("get_summary")) {
                Intent intent = new Intent(INITIAL_MESSAGE);
                intent.putExtra("initialnews_getsummary_message", message);
                localBroadcastManager.sendBroadcast(intent);
            }
        }

        private Handler mHandler = new Handler();

        private Runnable mReconnectTask = new Runnable() {

            @Override
            public void run() {
                Log.e("trader", "runable rec");
                mWebSocketClient.reconnect();
            }
        };

     /*   @Override
        public void onWebsocketPing(WebSocket conn, Framedata f) {
            super.onWebsocketPing(conn, f);
        }

        @Override
        public void onWebsocketPong(WebSocket conn, Framedata f) {
            super.onWebsocketPong(conn, f);
        }*/

        @Override
        public void onClose(int code, String reason, boolean remote) {
            System.out.println("关闭..." + reason);
            runOnUiThread(new Runnable() {
                @Override
                public void run() {
                    if (Flagchange.getFlag() != 1) {
                        int i = 0;
                        timer.cancel();
                        Intent intent = new Intent(INITIAL_MESSAGE);
                        intent.putExtra("connecting_nointernet", "1");
                        localBroadcastManager.sendBroadcast(intent);

                        while (!ValidateUtil.isNetworkAvalible(context)) {
                            if (i == 0) {
                                i = 1;
                            }
                            System.out.println("关闭..." + i);
                            SystemClock.sleep(1000);
                            i++;
                        }
                    }

                }
            });

            Log.e("trader", "start reconnected");

        }

        @Override
        public void onError(Exception ex) {
            System.out.println("异常" + ex);
        }
    }
}
