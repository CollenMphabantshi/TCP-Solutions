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


import android.app.Activity;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.text.Editable;
import android.text.TextWatcher;
import android.view.KeyEvent;
import android.view.View;
import android.view.View.OnKeyListener;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.TextView.OnEditorActionListener;

public class PreviousCaseBasicInfo  extends Activity{

	
	
	private ListView list;
	private ArrayList<String> caseData;
	private JSONArray json;
	private String username;
	private String searchVal;
	private Encryption enc;
	private EditText searchBox;
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.previous_cases);
		
		try{
			
			initialiseVariables();
			setEventMethods();
			List<NameValuePair> pairs = new ArrayList<NameValuePair>();
	        pairs.add(new BasicNameValuePair("rquest","getFOCaseList"));
	        pairs.add(new BasicNameValuePair("fopnumber",Encryption.bytesToHex(enc.encrypt(username)) ));
	        new Read().execute(pairs);
	        
	        
		}catch(Exception e){e.printStackTrace();}
		
		
		
	}
	
	public void initialiseVariables(){
		enc = new Encryption();
		searchVal = "";
		try{
			username = getIntent().getExtras().getString("USERNAME");
		}catch(Exception e){e.printStackTrace();}
		list = (ListView) findViewById(R.id.previousCase_lv);
		searchBox = (EditText) findViewById(R.id.previousCase_searchBox);
		caseData = new ArrayList<String>();
		
	}
	
	public void setEventMethods(){
        list.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> parent, View view,int position, long id) {
				// TODO Auto-generated method stub
				
				int pos = position;
				
				String itemValue = (String) list.getItemAtPosition(position);
				
				try {
					
					//Class myClass = Class.forName("com.example.mobileforensics.BASICCASEDATA");
					
					Intent select = new Intent(getApplicationContext(), BasicCaseData.class);
					try{
						select.putExtra("USERNAME", getIntent().getExtras().getString("USERNAME"));
						select.putExtra("VicName", new String(enc.decrypt(json.getJSONObject(position).getJSONArray("sceneData").getJSONObject(0).getString("vicName"))));
						select.putExtra("VicID", new String(enc.decrypt(json.getJSONObject(position).getJSONArray("sceneData").getJSONObject(0).getString("vicID"))));
						select.putExtra("SceneTime", new String(enc.decrypt(json.getJSONObject(position).getJSONArray("sceneData").getJSONObject(0).getString("sceneTime"))));
						select.putExtra("SceneDate", new String(enc.decrypt(json.getJSONObject(position).getJSONArray("sceneData").getJSONObject(0).getString("sceneDate"))));
						select.putExtra("SceneLocation", new String(enc.decrypt(json.getJSONObject(position).getJSONArray("sceneData").getJSONObject(0).getString("sceneLocation"))));
						select.putExtra("SceneTemperature", new String(enc.decrypt(json.getJSONObject(position).getJSONArray("sceneData").getJSONObject(0).getString("sceneTemparature"))));
						select.putExtra("ioName", new String(enc.decrypt(json.getJSONObject(position).getJSONArray("sceneData").getJSONObject(0).getString("ioName"))));
						select.putExtra("ioCellNumber", new String(enc.decrypt(json.getJSONObject(position).getJSONArray("sceneData").getJSONObject(0).getString("ioCellNumber"))));
						select.putExtra("foosName", new String(enc.decrypt(json.getJSONObject(position).getJSONArray("sceneData").getJSONObject(0).getString("foosName"))));
						startActivity(select);
					}catch(Exception e)
					{e.printStackTrace();}
					
					
				} catch (Exception e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
				
				
				
			}
        	
		});
        
        searchBox.addTextChangedListener(new TextWatcher() {
			
			@Override
			public void onTextChanged(CharSequence arg0, int arg1, int arg2, int arg3) {
				// TODO Auto-generated method stub
				
			}
			
			@Override
			public void beforeTextChanged(CharSequence arg0, int arg1, int arg2,
					int arg3) {
				// TODO Auto-generated method stub
				
			}
			
			@Override
			public void afterTextChanged(Editable val) {
				// TODO Auto-generated method stub
				searchCases(val.toString());
			}
		});
	}
	
	public void searchCases(String search){
		try{
			if(search != null && search.length() != 0)
			{
				List<NameValuePair> pairs = new ArrayList<NameValuePair>();
		        pairs.add(new BasicNameValuePair("rquest","findFOCases"));
		        pairs.add(new BasicNameValuePair("search",Encryption.bytesToHex(enc.encrypt(search)) ));
		        new Read().execute(pairs);
			}
	        
		}catch(Exception e){e.printStackTrace();}
	}
	public void addToList() throws Exception{
		try{
			caseData.clear();
		}catch(Exception e){e.printStackTrace();}
		for(int i =0; i < json.length();i++){
			String sceneType = json.getJSONObject(i).getJSONArray("sceneData").getJSONObject(0).getString("sceneTypeID");
			String mDate = json.getJSONObject(i).getJSONArray("sceneData").getJSONObject(0).getString("sceneDate");
			String mTime = json.getJSONObject(i).getJSONArray("sceneData").getJSONObject(0).getString("sceneTime");
			System.out.println("------("+i+") : "+(new String(enc.decrypt(json.getJSONObject(i).getString("caseNumber")))));
			caseData.add(new String(enc.decrypt(sceneType))+" \t\t"+new String(enc.decrypt(mDate))+"\t"+new String(enc.decrypt(mTime)));
		}
		ArrayAdapter<String> adapter = new ArrayAdapter<String>(this,
		        android.R.layout.simple_list_item_1, android.R.id.text1,caseData.toArray(new String[]{}));
		// Assign adapter to ListView
		list.setAdapter(adapter);
	}
	
	public JSONArray request(String url, List<NameValuePair> request)
            throws ClientProtocolException, IOException, IllegalStateException,
            JSONException {
		
        	DefaultHttpClient client = (DefaultHttpClient) WebServiceWrapper.getNewHttpClient();
            HttpPost post = new HttpPost(url);
            
            UrlEncodedFormEntity entity = new UrlEncodedFormEntity(request,HTTP.UTF_8);
            post.setEntity(entity);
            
            HttpResponse response = client.execute(post);
            
            Scanner in = new Scanner(response.getEntity().getContent());
            String line ="";
            
            while(in.hasNextLine()){
            	line += in.nextLine();
            }
            
           
            System.out.println("OUT: "+line);
            JSONArray tmp = new JSONArray(line);
            
           
            in.close();
            return tmp;
    }
    
    
    
    public class Read extends AsyncTask<List<NameValuePair>, Integer,JSONArray>{

		@Override
		protected JSONArray doInBackground(List<NameValuePair>... params) {
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
		protected void onPostExecute(JSONArray result) {
			// TODO Auto-generated method stub
			super.onPostExecute(result);
			try{
				if(result != null)
				{
					addToList();
				}
			}catch(Exception e){
				e.printStackTrace();
			}
		}
	
    }

}
