package com.banchi.collen;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.util.ArrayList;
import java.util.List;
 
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.StringEntity;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.params.HttpProtocolParams;
import org.apache.http.protocol.HTTP;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;
 
import android.app.Activity;
import android.os.AsyncTask;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
 
public class main extends Activity {
 
    TextView tv;
    Button loginBtn;
    String text;
    EditText username;
    EditText password;
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.main);
 
        tv  = (TextView)findViewById(R.id.responseTxt);
        text = "";
        username = (EditText)findViewById(R.id.usernameId);
        password = (EditText)findViewById(R.id.passwordId);
        loginBtn = (Button) findViewById(R.id.logginId);
        loginBtn.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				
				JSONObject jo = new JSONObject();
				try {
					jo.accumulate("rquest", "login");
					jo.accumulate("username", "p11111111");
					jo.accumulate("password", "open");
					jo.accumulate("platform", "android");
					
					
					new Read().execute(jo);
				} catch (Exception e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
				
			}
		});
        /*try {
            postData();
        } catch (JSONException e) {
            // TODO Auto-generated catch block
            e.printStackTrace();
        }*/
    }
 
    public String request(String url, JSONObject request)
            throws ClientProtocolException, IOException, IllegalStateException,
            JSONException {

        	DefaultHttpClient client = (DefaultHttpClient) WebServiceWrapper.getNewHttpClient();

            HttpPost post = new HttpPost(url);
            List<NameValuePair> pairs = new ArrayList<NameValuePair>();  

            pairs.add(new BasicNameValuePair("rquest","login"));
            pairs.add(new BasicNameValuePair("username",username.getText().toString()));  
            pairs.add(new BasicNameValuePair("password",password.getText().toString()));  
            pairs.add(new BasicNameValuePair("platform","android"));
            
            UrlEncodedFormEntity entity = new UrlEncodedFormEntity(pairs,HTTP.UTF_8);
            //post.setEntity(new StringEntity(request.toString(), "utf-8"));
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
            return sb.toString();
    }
    
    
    
    public class Read extends AsyncTask<JSONObject, Integer, String>{

		@Override
		protected String doInBackground(JSONObject... params) {
			// TODO Auto-generated method stub
			try {
				text = request("https://192.168.56.1/ws/models/api.php", params[0]);
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
			System.out.println("RESPONSE >> "+text);
			return text;
		}
		
		@Override
		protected void onPostExecute(String result) {
			// TODO Auto-generated method stub
			super.onPostExecute(result);
			tv.setText(result);
		}
	
    }
}
