package pro.jdbc.domain;

public class Crank {


	public int getCrank_id() {
		return crank_id;
	}
	public void setCrank_id(int crank_id) {
		this.crank_id = crank_id;
	}
	public int getCid() {
		return cid;
	}
	public void setCid(int cid) {
		this.cid = cid;
	}
	public String getUser() {
		return user;
	}
	public void setUser(String user) {
		this.user = user;
	}
	public String getTeam() {
		return team;
	}
	public void setTeam(String team) {
		this.team = team;
	}
	public long getLastS() {
		return lastS;
	}
	public void setLastS(long lastS) {
		this.lastS = lastS;
	}
	public int getSolvedC() {
		return solvedC;
	}
	public void setSolvedC(int solvedC) {
		this.solvedC = solvedC;
	}

	public long getPenatly() {
		return penatly;
	}
	public void setPenatly(long penatly) {
		this.penatly = penatly;
	}
	public String getSolvedP() {
		return SolvedP;
	}
	public void setSolvedP(String solvedP) {
		SolvedP = solvedP;
	}
	public String getUnsolvedP() {
		return UnsolvedP;
	}
	public void setUnsolvedP(String unsolvedP) {
		UnsolvedP = unsolvedP;
	}
	
	public String getFb() {
		return fb;
	}
	public void setFb(String fb) {
		this.fb = fb;
	}

	private int crank_id ;
	private int cid ;
    private String user;
    private String team;
    private long  lastS;
	private int solvedC;
    private long penatly;
    private String SolvedP;
    private String UnsolvedP;
    private String fb;

}
