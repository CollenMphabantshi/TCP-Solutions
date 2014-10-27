package com.example.mobileforensics.models;

import java.io.IOException;
import java.util.List;
import java.util.Scanner;

import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.protocol.HTTP;
import org.json.JSONException;
import org.json.JSONObject;

import com.example.mobileforensics.WebServiceWrapper;

public class SharpRequests {
	public SharpRequests(){
		
	}
	
	public JSONObject request(String url, List<NameValuePair> request)
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
          
            JSONObject tmp = new JSONObject(line);
            in.close();
            return tmp;
    }
}
