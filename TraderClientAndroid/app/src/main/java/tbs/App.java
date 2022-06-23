package tbs;

import android.app.Application;
import android.util.Log;

import com.tencent.smtt.sdk.QbSdk;

import org.litepal.LitePal;

public class App extends Application {
    @Override
    public void onCreate() {
        super.onCreate();
        //初始化数据
        LitePal.initialize(this);

        QbSdk.PreInitCallback cb= new QbSdk.PreInitCallback() {
            @Override
            public void onCoreInitFinished() {

            }

            @Override
            public void onViewInitFinished(boolean b) {
                Log.d("App","onViewInitFinished"+b);

            }
        };
        QbSdk.initX5Environment(getApplicationContext(),cb);
    }
}
