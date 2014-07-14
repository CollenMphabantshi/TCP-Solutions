package com.example.mobileforensics;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;

public class Home extends Activity{
	Button createCase, previousCase, generalReport;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.home);
		this.initialiseVariables();
		this.selectClass();
	}
	
	public void initialiseVariables(){
		
		createCase = (Button) findViewById(R.id.createCaseId);
		previousCase = (Button) findViewById(R.id.previousCaseId);
		generalReport = (Button) findViewById(R.id.basicReportId);
	}
	
	public void selectClass(){
		
		createCase.setOnClickListener(new View.OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				Intent open = new Intent("com.example.mobileforensics.SCENEMENU");
				startActivity(open);
				
			}
		});
		
		previousCase.setOnClickListener(new View.OnClickListener() {
					
					@Override
					public void onClick(View v) {
						// TODO Auto-generated method stub
						
					}
				});
		
		generalReport.setOnClickListener(new View.OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				
			}
		});
	}
	
	

}
