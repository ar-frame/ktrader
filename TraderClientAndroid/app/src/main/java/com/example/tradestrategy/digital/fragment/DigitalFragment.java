package com.example.tradestrategy.digital.fragment;

import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.example.tradestrategy.R;

import java.util.concurrent.LinkedBlockingDeque;
import java.util.concurrent.ThreadPoolExecutor;
import java.util.concurrent.TimeUnit;

public class DigitalFragment extends Fragment {
    private ThreadPoolExecutor digitalpool;
    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        View view=inflater.inflate(R.layout.fragment_digital,container,false);

        digitalpool=new ThreadPoolExecutor(
                3,30,30L, TimeUnit.SECONDS,
                new LinkedBlockingDeque<Runnable>(128)
        );

        return view;
    }



}
