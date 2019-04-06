package wurms.programmer.logic;

import wurms.programmer.database.DatabaseX;

public class Logic 
{
    private DatabaseX m_CDatabase;

    public Logic() 
    {
        setDatabase( createDatabase() );
    }

    public DatabaseX getDatabase() 
    {
        return m_CDatabase;
    }

    private void setDatabase(DatabaseX p_CDatabase) 
    {
        m_CDatabase = p_CDatabase;
    }

    private DatabaseX createDatabase() 
    {
        DatabaseX database = getDatabase();
        if(database == null)
        {
            database = new DatabaseX();
        }
        return database;
    }    
}
