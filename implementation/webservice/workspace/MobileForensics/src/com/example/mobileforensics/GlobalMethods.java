package com.example.mobileforensics;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.util.Scanner;

import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.protocol.HTTP;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.TextView;
import android.widget.Toast;
import android.widget.AdapterView.OnItemSelectedListener;

public interface GlobalMethods {
	public abstract void setOnClickEvents();
	
	public void showHideButtons();
	
	public void hidePage();

	public void showPage();


	public boolean validateNextPage();

	public List<NameValuePair> getPostData();
	
	public String getVictimGender();
	
	public String getVictimRace();
	
	public void knownVictim();

	public void saveDataOnAction()throws Exception;
	public void saveData(JSONObject data)throws Exception;
	
	public void resendData()throws Exception;
	
	public JSONObject request(String url, List<NameValuePair> request)throws ClientProtocolException, IOException, IllegalStateException,
    JSONException;
}
