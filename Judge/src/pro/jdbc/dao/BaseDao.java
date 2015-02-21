package pro.jdbc.dao;

import java.util.List;


public interface BaseDao {
	public <T> void add(String[]args, T instance);
	public <T> void update(String[]args, T instance );
	public <T> void delete(T instance);
	public <T> List<T> findByProperties(String[]args,Class<T> clazz, Object...objs);
}
