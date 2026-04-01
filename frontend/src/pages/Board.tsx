import { useEffect, useState, useCallback } from 'react';
import { useParams, Link } from 'react-router-dom';
import { fetchCatalog } from '../api/client';
import { PostForm } from '../components/PostForm';

export function Board() {
  const { board } = useParams<{ board: string }>();
  const [threads, setThreads] = useState<any[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  const loadCatalog = useCallback(() => {
    if (!board) return;
    setLoading(true);
    fetchCatalog(board)
      .then((data) => {
        // Flatten the catalog pages to get threads
        const allThreads = data.flatMap((page: any) => page.threads);
        setThreads(allThreads);
        setLoading(false);
      })
      .catch((err) => {
        setError(err.message);
        setLoading(false);
      });
  }, [board]);

  useEffect(() => {
    loadCatalog();
  }, [loadCatalog]);

  if (loading) return <div>Loading /{board}/...</div>;
  if (error) return <div>Error: {error}</div>;

  return (
    <div>
      <h1>/{board}/ - Catalog</h1>
      
      <div style={{ display: 'flex', justifyContent: 'center', marginBottom: '2rem' }}>
        <PostForm board={board!} onSuccess={() => loadCatalog()} />
      </div>

      <div className="catalog-grid" style={{ display: 'flex', flexWrap: 'wrap', gap: '1rem' }}>
        {threads.map((thread) => (
          <div key={thread.no} className="catalog-thread" style={{ width: '200px', border: '1px solid #ccc', padding: '0.5rem' }}>
            <Link to={`/${board}/thread/${thread.no}`}>
              {thread.thumb && thread.pending_approval !== 1 && (
                <img
                  src={`/${board}/thumb/${thread.thumb}`}
                  alt={thread.filename}
                  style={{ maxWidth: '100%', maxHeight: '150px' }}
                />
              )}
              {thread.thumb && thread.pending_approval === 1 && (
                <div style={{ maxWidth: '100%', height: '150px', background: '#ccc', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
                  [Pending Approval]
                </div>
              )}
              <div>
                <strong>{thread.sub || thread.no}</strong>
                <p dangerouslySetInnerHTML={{ __html: thread.com }}></p>
              </div>
            </Link>
          </div>
        ))}
      </div>
    </div>
  );
}
