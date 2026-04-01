import { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import { fetchCatalog } from '../api/client';

const BOARDS = ['soy', 'qa', 'pol'];

export function Home() {
  const [boardData, setBoardData] = useState<{ [key: string]: any[] }>({});
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    setLoading(true);
    Promise.all(
      BOARDS.map((board) =>
        fetchCatalog(board)
          .then((data) => {
            // Flatten the catalog pages and grab the top 5 most recent/bumped threads
            const allThreads = data.flatMap((page: any) => page.threads);
            return { board, threads: allThreads.slice(0, 5) };
          })
          .catch((err) => {
            console.error(`Failed to load /${board}/:`, err);
            return { board, threads: [] }; // fail gracefully for individual boards
          })
      )
    )
      .then((results) => {
        const newData: { [key: string]: any[] } = {};
        results.forEach(({ board, threads }) => {
          newData[board] = threads;
        });
        setBoardData(newData);
        setLoading(false);
      })
      .catch((err) => {
        setError(err.message);
        setLoading(false);
      });
  }, []);

  if (loading) return <div>Loading home page...</div>;
  if (error) return <div>Error: {error}</div>;

  return (
    <div>
      <h1 style={{ textAlign: 'center', marginBottom: '2rem' }}>Welcome to Soyjak Party</h1>
      
      <div style={{ display: 'flex', flexDirection: 'column', gap: '2rem' }}>
        {BOARDS.map((board) => (
          <div key={board} style={{ border: '1px solid #ccc', padding: '1rem', background: '#fafafa' }}>
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', borderBottom: '2px solid #ccc', paddingBottom: '0.5rem', marginBottom: '1rem' }}>
              <h2 style={{ margin: 0 }}>
                <Link to={`/${board}/`} style={{ textDecoration: 'none', color: '#000' }}>/{board}/ - Recent Threads</Link>
              </h2>
              <Link to={`/${board}/`}>[View All]</Link>
            </div>
            
            <div className="catalog-grid" style={{ display: 'flex', flexWrap: 'wrap', gap: '1rem' }}>
              {boardData[board]?.length > 0 ? (
                boardData[board].map((thread) => (
                  <div key={thread.no} className="catalog-thread" style={{ width: '200px', background: '#fff', border: '1px solid #ddd', padding: '0.5rem' }}>
                    <Link to={`/${board}/thread/${thread.no}`} style={{ textDecoration: 'none', color: '#333' }}>
                      {thread.thumb && thread.pending_approval !== 1 && (
                        <img
                          src={`/${board}/thumb/${thread.thumb}`}
                          alt={thread.filename}
                          style={{ maxWidth: '100%', maxHeight: '150px', display: 'block', margin: '0 auto 0.5rem' }}
                        />
                      )}
                      {thread.thumb && thread.pending_approval === 1 && (
                        <div style={{ maxWidth: '100%', height: '150px', background: '#ccc', display: 'flex', alignItems: 'center', justifyContent: 'center', margin: '0 auto 0.5rem' }}>
                          [Pending Approval]
                        </div>
                      )}
                      <div>
                        <strong style={{ display: 'block', textOverflow: 'ellipsis', overflow: 'hidden', whiteSpace: 'nowrap' }}>
                          {thread.sub || thread.no}
                        </strong>
                        <p dangerouslySetInnerHTML={{ __html: thread.com }} style={{ fontSize: '0.9rem', margin: '0.5rem 0 0', maxHeight: '100px', overflow: 'hidden', textOverflow: 'ellipsis' }}></p>
                      </div>
                    </Link>
                  </div>
                ))
              ) : (
                <div>No recent threads found or board is empty.</div>
              )}
            </div>
          </div>
        ))}
      </div>
    </div>
  );
}
