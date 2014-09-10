package com.example.mobileforensics;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.util.ArrayList;
import java.util.List;

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

import android.app.Activity;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.Toast;

public class Loggin extends Activity{
	private Button login;
	private EditText username,password;
	private CheckBox rememberMe;
	private JSONObject json;
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.loggin);
		this.intialiseVariable();
		//this.doLogin();
		Intent open = new Intent("com.example.mobileforensics.HOME");
		startActivity(open);
	}
	
	
	@Override
	protected void onPause() {
		// TODO Auto-generated method stub
		super.onPause();
		finish();
	}
	
	public void doLogin(){
		
		
			login.setOnClickListener(new View.OnClickListener() {
				
				@Override
				public void onClick(View v) {
					// TODO Auto-generated method stub
					startLogin();
					
					try {
						startMenu();
					} catch (JSONException e) {
						// TODO Auto-generated catch block
						e.printStackTrace();
					}
					
				}
			});
			
		
	}

	public void startLogin(){
		
		String user = username.getText().toString();
		
		String pass = password.getText().toString();
		
		List<NameValuePair> pairs = new ArrayList<NameValuePair>();  

        pairs.add(new BasicNameValuePair("rquest","login"));
        pairs.add(new BasicNameValuePair("username",user));  
        pairs.add(new BasicNameValuePair("password",pass));  
        pairs.add(new BasicNameValuePair("platform","droid"));
        new Read().execute(pairs);
	}

	private void startMenu() throws JSONException{
		if(json != null)
		{
			String status = json.getString("status");
			String message = json.getString("msg");
			
			
			if(status.toLowerCase().equals("success"))
			{
				Intent open = new Intent("com.example.mobileforensics.HOME");
				startActivity(open);
			}else{
				
				Toast.makeText(getApplicationContext(),message, Toast.LENGTH_LONG).show();
				
			}
		}else{
			
			Toast.makeText(getApplicationContext(),"Server connection problem detected. Please contact admin.", Toast.LENGTH_LONG).show();
		}
		
	}
	public void intialiseVariable(){
		login = (Button) findViewById(R.id.logginId);
		username = (EditText) findViewById(R.id.usernameId);
		password = (EditText) findViewById(R.id.passwordId);
		rememberMe = (CheckBox) findViewById(R.id.rememberMeId);
	}
	
	public JSONObject request(String url,  List<NameValuePair> pairs)
            throws ClientProtocolException, IOException, IllegalStateException,
            JSONException {
		
        	DefaultHttpClient client = (DefaultHttpClient) WebServiceWrapper.getNewHttpClient();
            HttpPost post = new HttpPost(url);
            UrlEncodedFormEntity entity = new UrlEncodedFormEntity(pairs,HTTP.UTF_8);
            post.setEntity(entity);
            HttpResponse response = client.execute(post);
            BufferedReader in = new BufferedReader(new InputStreamReader(response.getEntity().getContent()));
            String line = "";
            StringBuffer sb = new StringBuffer();
            String NL = System.getProperty("line.separator");
            while ((line = in.readLine()) != null) {
            	sb.append(line + NL);
            }
            in.close();
            
            System.out.println("OUTPUT: >>>>> "+sb.toString());
            JSONObject obj = new JSONObject(sb.toString());
            return obj;
    }
    
    
    
    public class Read extends AsyncTask<List<NameValuePair>, Integer, JSONObject>{

		@Override
		protected JSONObject doInBackground(List<NameValuePair>... params) {
			// TODO Auto-generated method stub
			try {
				json = request(GlobalValues.WS_URL, params[0]);
			} catch (ClientProtocolException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			} catch (IllegalStateException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			} catch (IOException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			} catch (JSONException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			
			return json;
		}
		
		@Override
		protected void onPostExecute(JSONObject result) {
			// TODO Auto-generated method stub
			super.onPostExecute(result);
			try {
				startMenu();
			} catch (JSONException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		}
	
    }

}
