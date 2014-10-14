package com.example.mobileforensics.helpers;

import com.example.mobileforensics.Encryption;

public class Case {
	private String vicName;
	private String vicID;
	private String ioName;
	private String ioCellNo;
	private String foosName;
	private String sceneLocation;
	private String sceneDate;
	private String sceneTime;
	private String sceneTemp;
	private String sceneType;
	private Encryption enc;
	public Case(String vicName, String vicID, String ioName, String ioCellNo,String foosName,
			String sceneLocation, String sceneDate, String sceneTime,
			String sceneTemp, String sceneType) {
		super();
		this.vicName = vicName;
		this.vicID = vicID;
		this.ioName = ioName;
		this.foosName = foosName;
		this.sceneLocation = sceneLocation;
		this.sceneDate = sceneDate;
		this.sceneTime = sceneTime;
		this.sceneTemp = sceneTemp;
		this.sceneType = sceneType;
		enc = new Encryption();
	}
	public String getVicName() {
		return vicName;
	}
	public void setVicName(String vicName) {
		this.vicName = vicName;
	}
	public String getVicID() {
		return vicID;
	}
	public void setVicID(String vicID) {
		this.vicID = vicID;
	}
	public String getIoName() {
		return ioName;
	}
	public void setIoName(String ioName) {
		this.ioName = ioName;
	}
	
	
	public String getIoCellNo() {
		return ioCellNo;
	}
	public void setIoCellNo(String ioCellNo) {
		this.ioCellNo = ioCellNo;
	}
	public String getFoosName() {
		return foosName;
	}
	public void setFoosName(String foosName) {
		this.foosName = foosName;
	}
	public String getSceneLocation() {
		return sceneLocation;
	}
	public void setSceneLocation(String sceneLocation) {
		this.sceneLocation = sceneLocation;
	}
	public String getSceneDate() {
		return sceneDate;
	}
	public void setSceneDate(String sceneDate) {
		this.sceneDate = sceneDate;
	}
	public String getSceneTime() {
		return sceneTime;
	}
	public void setSceneTime(String sceneTime) {
		this.sceneTime = sceneTime;
	}
	public String getSceneTemp() {
		return sceneTemp;
	}
	public void setSceneTemp(String sceneTemp) {
		this.sceneTemp = sceneTemp;
	}
	public String getSceneType() {
		return sceneType;
	}
	public void setSceneType(String sceneType) {
		this.sceneType = sceneType;
	}
	
	
	
	
	
}