package com.example.mobileforensics;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
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
import org.json.JSONException;
import org.json.JSONObject;

import android.app.Activity;
import android.os.AsyncTask;
import android.os.Bundle;
import android.widget.EditText;
import android.widget.RadioButton;

public class Blunt extends Activity{

	private EditText ioName;
	private EditText ioSurname;
	private EditText ioRank;
	private EditText ioCellNo;
	
	private EditText foosName;
	private EditText foosSurname;
	private EditText foosRank;
	
	private EditText victimName;
	private EditText victimSurname;
	private EditText victimIDNo;
	
	
	private RadioButton rgbMale;
	private RadioButton rgbFemale;
	private RadioButton rgbUnknownGender;
	
	private RadioButton rgbAsian;
	private RadioButton rgbBlack;
	private RadioButton rgbColoured;
	private RadioButton rgbWhite;
	private RadioButton rgbUnknownRace;

	
	private JSONObject json;
	private final static String WS_URL = "https://192.168.56.1/ws/models/api.php";
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.blunt);
		
		ioName = (EditText)findViewById(R.id.io_name);
		ioSurname = (EditText)findViewById(R.id.io_surname);
		ioRank = (EditText)findViewById(R.id.io_rank);
		ioCellNo = (EditText)findViewById(R.id.io_cell);
		
		foosName = (EditText)findViewById(R.id.foos_name);
		foosSurname = (EditText)findViewById(R.id.foos_surname);
		foosRank = (EditText)findViewById(R.id.foos_rank);
		
		victimName = (EditText)findViewById(R.id.victim_name);
		victimSurname = (EditText)findViewById(R.id.victim_surname);
		victimIDNo = (EditText)findViewById(R.id.victim_id);
		
		rgbMale = (RadioButton)findViewById(R.id.rgbMale);
		rgbFemale = (RadioButton)findViewById(R.id.rgbFemale);
		rgbUnknownGender = (RadioButton)findViewById(R.id.rgbUnknownGender);
		
		rgbAsian = (RadioButton)findViewById(R.id.rgbAsian);
		rgbBlack = (RadioButton)findViewById(R.id.rgbBlack);
		rgbColoured = (RadioButton)findViewById(R.id.rgbColoured);
		rgbWhite = (RadioButton)findViewById(R.id.rgbWhite);
		rgbUnknownRace = (RadioButton)findViewById(R.id.rgbUnknownRace);
		
	}
	
	public JSONObject request(String url, List<NameValuePair> request)
            throws ClientProtocolException, IOException, IllegalStateException,
            JSONException {
		
        	DefaultHttpClient client = (DefaultHttpClient) com.example.mobileforensics.helpers.WebServiceWrapper.getNewHttpClient();
            HttpPost post = new HttpPost(url);
            
            UrlEncodedFormEntity entity = new UrlEncodedFormEntity(request,HTTP.UTF_8);
            post.setEntity(entity);
            
            HttpResponse response = client.execute(post);
            
            Scanner in = new Scanner(response.getEntity().getContent());
            String line ="";
            
            while(in.hasNextLine()){
            	line += in.nextLine();
            }
            
            JSONObject tmp = new JSONObject(line);
            in.close();
            return tmp;
    }
    
    
    
    public class Read extends AsyncTask<List<NameValuePair>, Integer,JSONObject>{

		@Override
		protected JSONObject doInBackground(List<NameValuePair>... params) {
			// TODO Auto-generated method stub
			try {
				json = request(WS_URL, params[0]);
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
			
		}
	
    }

}
