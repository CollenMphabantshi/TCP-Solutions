package com.example.mobileforensics;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.Toast;

public class Loggin extends Activity{
	Button login;
	EditText username,password;
	CheckBox rememberMe;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.loggin);
		this.intialiseVariable();
		this.doLogin();
		
		
	}
	
	
	
	@Override
	protected void onPause() {
		// TODO Auto-generated method stub
		super.onPause();
		finish();
	}
	
	public void doLogin(){
		
		if(validateLogin()){
			login.setOnClickListener(new View.OnClickListener() {
				
				@Override
				public void onClick(View v) {
					// TODO Auto-generated method stub
					Intent open = new Intent("com.example.mobileforensics.HOME");
					startActivity(open);
				}
			});
			
		}else{
			
		
			
		}
	}

	public boolean validateLogin(){
		
		String user = username.getText().toString();
		
		String pass = password.getText().toString();
		
		if(user == "collen" || pass == "123"){
			//Toast.makeText(Loggin.this, user + " You have successfully logged on", 5).show();
			return true;
		}else
			return true;
		
	}

	public void intialiseVariable(){
		login = (Button) findViewById(R.id.logginId);
		username = (EditText) findViewById(R.id.usernameId);
		password = (EditText) findViewById(R.id.passwordId);
		rememberMe = (CheckBox) findViewById(R.id.rememberMeId);
		
	}
	
	

}
