package com.example.fileuploadtest;

import java.io.DataOutputStream;
import java.io.File;
import java.io.FileInputStream;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.ArrayList;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Intent;
import android.database.Cursor;
import android.graphics.BitmapFactory;
import android.net.Uri;
import android.os.Bundle;
import android.provider.MediaStore;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Adapter;
import android.widget.AdapterView;
import android.widget.AdapterView.AdapterContextMenuInfo;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

public class UploadToServer extends Activity{
	TextView messageText;
    Button uploadButton,selectImages,buttonLoadImage;
    ImageView imageView0,imageView1,imageView2,imageView3,imageView4,imageView5,imageView6,imageView7,imageView8;
    int serverResponseCode = 0;
    ProgressDialog dialog = null;
    Uri currImageURI;
    String  upLoadServerUri = "http://forensicsapp.co.za/webapp/images/images.php";
    private static int RESULT_LOAD_IMAGE = 1;
    int count = 0;
    ArrayList<String> uploadFileName = new ArrayList<>();
    String filename ;
     
    @Override
    public void onCreate(Bundle savedInstanceState) {
         
        super.onCreate(savedInstanceState);
        setContentView(R.layout.testimage);
        initializeVariables();  
        setOnclicks();
        
     
    }
    public void initializeVariables(){
    	
       uploadButton = (Button)findViewById(R.id.uploadButton);
       messageText  = (TextView)findViewById(R.id.messageText);
       buttonLoadImage = (Button) findViewById(R.id.buttonLoadPicture);
       imageView0 = (ImageView) findViewById(R.id.imgView0);
       imageView1 = (ImageView) findViewById(R.id.imgView1);
       imageView2 = (ImageView) findViewById(R.id.imgView2);
       imageView3 = (ImageView) findViewById(R.id.imgView3);
       imageView4 = (ImageView) findViewById(R.id.imgView4);
       imageView5 = (ImageView) findViewById(R.id.imgView5);
       imageView6 = (ImageView) findViewById(R.id.imgView6);
       imageView7 = (ImageView) findViewById(R.id.imgView7);
       imageView8 = (ImageView) findViewById(R.id.imgView8);
       
       
    
    }
    public void setOnclicks(){
    	uploadButton.setOnClickListener(new View.OnClickListener() {
	           
            @Override
            public void onClick(View v) {
                 
                dialog = ProgressDialog.show(UploadToServer.this, "", "Uploading file...", true);
                 
                new Thread(new Runnable() {
                        public void run() {
                             runOnUiThread(new Runnable() {
                                    public void run() {
                                        messageText.setText("uploading started.....");
                                    }
                                });                      
                             for(int i=0; i < uploadFileName.size(); i++){
                            	 filename = uploadFileName.get(i);
                            	 uploadFile( filename );
                            	 
                             }                   
                        }
                      }).start();        
                }
            });
        
        
        
        buttonLoadImage.setOnClickListener(new View.OnClickListener() {
            
            @Override
            public void onClick(View arg0) {
                 
                Intent i = new Intent(
                        Intent.ACTION_PICK,
                        android.provider.MediaStore.Images.Media.EXTERNAL_CONTENT_URI);
                 
                startActivityForResult(i, RESULT_LOAD_IMAGE);
            }
        });
    	
    }
    
    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
         
        if (requestCode == RESULT_LOAD_IMAGE && resultCode == RESULT_OK && null != data) {
            Uri selectedImage = data.getData();
            String[] filePathColumn = { MediaStore.Images.Media.DATA };
 
            Cursor cursor = getContentResolver().query(selectedImage,
            filePathColumn, null, null, null);
            cursor.moveToFirst();
 
            int columnIndex = cursor.getColumnIndex(filePathColumn[0]);
            String picturePath = cursor.getString(columnIndex);
            cursor.close();
           
            uploadFileName.add(picturePath);
            messageText.setText("Path : "+uploadFileName);
            
            if(count == 0){
            	imageView0.setImageBitmap(BitmapFactory.decodeFile(picturePath));
            }else if(count == 1){
            	imageView1.setImageBitmap(BitmapFactory.decodeFile(picturePath));
            }else if(count == 2){
            	imageView2.setImageBitmap(BitmapFactory.decodeFile(picturePath));
            }else if(count == 3){
            	imageView3.setImageBitmap(BitmapFactory.decodeFile(picturePath));
            }else if(count == 4){
            	imageView4.setImageBitmap(BitmapFactory.decodeFile(picturePath));
            }else if(count == 5){
            	imageView5.setImageBitmap(BitmapFactory.decodeFile(picturePath));
            }else if(count == 6){
            	imageView6.setImageBitmap(BitmapFactory.decodeFile(picturePath));
            }else if(count == 7){
            	imageView7.setImageBitmap(BitmapFactory.decodeFile(picturePath));
            }else if(count == 8){
            	imageView8.setImageBitmap(BitmapFactory.decodeFile(picturePath));
            }
            count++;
        }
     
     
    }
   
   
 
    public int uploadFile(String sourceFileUri) {
           
           
          String fileName = sourceFileUri;
  
          HttpURLConnection conn = null;
          DataOutputStream dos = null;  
          String lineEnd = "\r\n";
          String twoHyphens = "--";
          String boundary = "*****";
          int bytesRead, bytesAvailable, bufferSize;
          byte[] buffer;
          int maxBufferSize = 1 * 1024 * 1024; 
          File sourceFile = new File(sourceFileUri); 
           
          if (!sourceFile.isFile()) {
               
               dialog.dismiss(); 
                
               Log.e("uploadFile", "Source File not exist :" + filename);
                
               runOnUiThread(new Runnable() {
                   public void run() {
                       messageText.setText("Source File not exist :"+ filename);
                   }
               }); 
                
               return 0;
            
          }
          else
          {
               try { 
                    
                     // open a URL connection to the Servlet
                   FileInputStream fileInputStream = new FileInputStream(sourceFile);
                   URL url = new URL(upLoadServerUri);
                    
                   // Open a HTTP  connection to  the URL
                   conn = (HttpURLConnection) url.openConnection(); 
                   conn.setDoInput(true); // Allow Inputs
                   conn.setDoOutput(true); // Allow Outputs
                   conn.setUseCaches(false); // Don't use a Cached Copy
                   conn.setRequestMethod("POST");
                   conn.setRequestProperty("Connection", "Keep-Alive");
                   conn.setRequestProperty("ENCTYPE", "multipart/form-data");
                   conn.setRequestProperty("Content-Type", "multipart/form-data;boundary=" + boundary);
                   conn.setRequestProperty("uploaded_file", fileName); 
                    
                   dos = new DataOutputStream(conn.getOutputStream());
          
                   dos.writeBytes(twoHyphens + boundary + lineEnd); 
                   dos.writeBytes("Content-Disposition: form-data; name= uploaded_file ;filename="+fileName+ lineEnd);
                    
                   dos.writeBytes(lineEnd);
          
                   // create a buffer of  maximum size
                   bytesAvailable = fileInputStream.available(); 
          
                   bufferSize = Math.min(bytesAvailable, maxBufferSize);
                   buffer = new byte[bufferSize];
          
                   // read file and write it into form...
                   bytesRead = fileInputStream.read(buffer, 0, bufferSize);  
                      
                   while (bytesRead > 0) {
                        
                     dos.write(buffer, 0, bufferSize);
                     bytesAvailable = fileInputStream.available();
                     bufferSize = Math.min(bytesAvailable, maxBufferSize);
                     bytesRead = fileInputStream.read(buffer, 0, bufferSize);   
                      
                    }
          
                   // send multipart form data necesssary after file data...
                   dos.writeBytes(lineEnd);
                   dos.writeBytes(twoHyphens + boundary + twoHyphens + lineEnd);
          
                   // Responses from the server (code and message)
                   serverResponseCode = conn.getResponseCode();
                   String serverResponseMessage = conn.getResponseMessage();
                     
                   Log.i("uploadFile", "HTTP Response is : "
                           + serverResponseMessage + ": " + serverResponseCode);
                    
                   if(serverResponseCode == 200){
                        
                       runOnUiThread(new Runnable() {
                            public void run() {
                                 
                                String msg = "File Upload Completed.\n\n See uploaded file here : \n\n"
                                              +" http://forensicsapp.co.za/webapp/images/uploads/"
                                              +filename;
                                 
                                messageText.setText(msg);
                                Toast.makeText(UploadToServer.this, "File Upload Complete.", 
                                             Toast.LENGTH_SHORT).show();
                            }
                        });                
                   }    
                    
                   //close the streams //
                   fileInputStream.close();
                   dos.flush();
                   dos.close();
                     
              } catch (MalformedURLException ex) {
                   
                  dialog.dismiss();  
                  ex.printStackTrace();
                   
                  runOnUiThread(new Runnable() {
                      public void run() {
                          messageText.setText("MalformedURLException Exception : check script url.");
                          Toast.makeText(UploadToServer.this, "MalformedURLException", 
                                                              Toast.LENGTH_SHORT).show();
                      }
                  });
                   
                  Log.e("Upload file to server", "error: " + ex.getMessage(), ex);  
              } catch (Exception e) {
                   
                  dialog.dismiss();  
                  e.printStackTrace();
                   
                  runOnUiThread(new Runnable() {
                      public void run() {
                          messageText.setText("Got Exception : see logcat ");
                          Toast.makeText(UploadToServer.this, "Got Exception : see logcat ", 
                                  Toast.LENGTH_SHORT).show();
                      }
                  });
                  Log.e("Upload file to server Exception", "Exception : "
                                                   + e.getMessage(), e);  
              }
              dialog.dismiss();       
              return serverResponseCode; 
               
           } // End else block 
         }
    
   

}
