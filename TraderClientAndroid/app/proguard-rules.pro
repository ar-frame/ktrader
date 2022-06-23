# Add project specific ProGuard rules here.
# You can control the set of applied configuration files using the
# proguardFiles setting in build.gradle.
#
# For more details, see
#   http://developer.android.com/guide/developing/tools/proguard.html

# If your project uses WebView with JS, uncomment the following
# and specify the fully qualified class name to the JavaScript interface
# class:
#-keepclassmembers class fqcn.of.javascript.interface.for.webview {
#   public *;
#}

# Uncomment this to preserve the line number information for
# debugging stack traces.
#-keepattributes SourceFile,LineNumberTable

# If you keep the line number information, uncomment this to
# hide the original source file name.
#-renamesourcefileattribute SourceFile



-keep public class * extends AppCompatActivity

#指定代码的压缩级别
-optimizationpasses 5
#是否使用大小写混合
-dontusemixedcaseclassnames
#优化/不优化输入的类文件
-dontoptimize
#是否混淆第三方JAR包
-dontskipnonpubliclibraryclasses
#混淆时是否做预校验
-dontpreverify
#混淆时是否记录日志
-verbose
#混淆时采用的算法
-optimizations!code/simplification/arithmetic,!field/*,!class/merging/*
#保护注解
-keepattributes *Annotation*
#保持JNI用到的native方法不被混淆
-keepclasseswithmembers class *{
    native<methods>;
    }
#保持自定义控件的构造函数不被混淆，因为自定义组件很可能直接写在布局文件中
-keepclasseswithmembers class *{
    public<init>(android.content.Context,android.util.AttributeSet);
}

#保持自定义控件的构造函数不被混淆
-keepclasseswithmembers class *{
    public <init>(android.content.Context,android.util.AttributeSet,int);
}

#保持布局中onClick属性指定的方法不被混淆
-keepclassmembers class * extends android.app.Activity{
    public void *(android.view.View);
}

#保持枚举enum类不被混淆
-keepclasseswithmembers enum * {
    public static **[] values();
    public static ** valueOf(java.lang.String);
}

#保持序列化的Parcelable不被混淆
-keep class * implements android.os.Parcelable{
    public static final android.os.Parcelable$Creator *;
}


