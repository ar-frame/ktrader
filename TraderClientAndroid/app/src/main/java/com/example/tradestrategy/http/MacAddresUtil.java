package com.example.tradestrategy.http;

import android.bluetooth.BluetoothAdapter;
import android.content.Context;
import android.net.wifi.WifiManager;
import android.os.Build;

import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;


/*获取Psuedo ID*/
public class MacAddresUtil {
    private  Context mContext;

    public MacAddresUtil(Context context) {
        this.mContext = context;
    }

    public String getUniqueID() {
        String m_szLongID = getPesudoUniqueID() + getWLANMACAddress() + getBTMACAddress();
        // compute md5
        MessageDigest m = null;
        try {
            m = MessageDigest.getInstance("MD5");
        } catch (NoSuchAlgorithmException e) {
            e.printStackTrace();
        }
        m.update(m_szLongID.getBytes(), 0, m_szLongID.length());
        // 获取MD5字节
        byte p_md5Data[] = m.digest();
        // 创建十六进制字符串
        String m_szUniqueID = new String();
        for (int i = 0; i < p_md5Data.length; i++) {
            int b = (0xFF & p_md5Data[i]);
            // 如果是一个数字，确保前面有0（适当的填充）
            if (b <= 0xF)
                m_szUniqueID += "0";
            // 将数字添加到字符串
            m_szUniqueID += Integer.toHexString(b);
        }   // 十六进制字符串转换为大写
        m_szUniqueID = m_szUniqueID.toUpperCase();
        return m_szUniqueID;
    }


    public String getPesudoUniqueID() {
        String m_szDevIDShort = "35" +         //we make this look like a valid IMEI
                Build.BOARD.length() % 10 +
                Build.BRAND.length() % 10 +
                Build.CPU_ABI.length() % 10 +
                Build.DEVICE.length() % 10 +
                Build.DISPLAY.length() % 10 +
                Build.HOST.length() % 10 +
                Build.ID.length() % 10 +
                Build.MANUFACTURER.length() % 10 +
                Build.MODEL.length() % 10 +
                Build.PRODUCT.length() % 10 +
                Build.TAGS.length() % 10 +
                Build.TYPE.length() % 10 +
                Build.USER.length() % 10;     //13 digits
        return m_szDevIDShort;
    }


    public String getWLANMACAddress() {
        WifiManager wm = (WifiManager) mContext.getSystemService(Context.WIFI_SERVICE);
        String m_szWLANMAC = wm.getConnectionInfo().getMacAddress();
        return m_szWLANMAC;
    }


    public String getBTMACAddress() {
        return "aaa";
//        BluetoothAdapter m_BluetoothAdapter = BluetoothAdapter.getDefaultAdapter();
//        String m_szBTMAC = m_BluetoothAdapter.getAddress();
//        return m_szBTMAC;
    }
}
