package com.example.mobileforensics.test;

import java.util.ArrayList;
import java.util.List;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONObject;

import com.example.mobileforensics.Encryption;
import com.example.mobileforensics.Loggin;
import com.example.mobileforensics.Sharp;
import com.example.mobileforensics.models.SharpRequests;

import android.app.Activity;
import android.app.LauncherActivity;
import android.content.Intent;
import android.test.ActivityUnitTestCase;
import android.widget.Button;

public class SharpTestCase extends ActivityUnitTestCase<LauncherActivity>{

	public SharpTestCase(Class<LauncherActivity> activityClass) {
		super(activityClass);
		// TODO Auto-generated constructor stub
	}
	
	@Override
	protected void setUp() throws Exception {
		// TODO Auto-generated method stub
		super.setUp();
		try{
			Intent open = new Intent(getInstrumentation().getContext(),Loggin.class);
			//startActivity(open, null, null);
			
			SharpRequests l = new SharpRequests();
			List<NameValuePair> pairs = new ArrayList<NameValuePair>();  
        	Encryption enc = new Encryption();
            pairs.add(new BasicNameValuePair("rquest",Encryption.bytesToHex(enc.encrypt("login"))));
			pairs.add(new BasicNameValuePair("username",Encryption.bytesToHex(enc.encrypt("p33333333"))));
			pairs.add(new BasicNameValuePair("password",Encryption.bytesToHex(enc.encrypt("open"))));  
		    pairs.add(new BasicNameValuePair("platform",Encryption.bytesToHex(enc.encrypt("droid"))));
			JSONObject ob = l.request("http://forensicsapp.co.za/webapp/models/api/php", pairs);
			System.out.println(ob.get("msg"));
			
		}catch(Exception e){
			e.printStackTrace();
			fail();
		}
	}

}